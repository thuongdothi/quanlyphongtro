<?php
// ==============================================================
// MODEL: INVOICE (HÓA ĐƠN TIỀN TRỌ & DỊCH VỤ)
// ==============================================================

class Invoice extends Model {
    protected string $table = 'invoices';

    /**
     * Lấy toàn bộ hóa đơn kèm phòng và khách thuê
     */
    public function getAllWithDetails(array $filters = []): array {
        $whereClauses = ["1 = 1"];
        $params = [];

        if (!empty($filters['month'])) {
            $whereClauses[] = "i.month = :month";
            $params[':month'] = (int)$filters['month'];
        }

        if (!empty($filters['year'])) {
            $whereClauses[] = "i.year = :year";
            $params[':year'] = (int)$filters['year'];
        }

        if (!empty($filters['status'])) {
            $whereClauses[] = "i.status = :status";
            $params[':status'] = $filters['status'];
        }

        if (!empty($filters['branch_id'])) {
            $whereClauses[] = "r.branch_id = :branch_id";
            $params[':branch_id'] = (int)$filters['branch_id'];
        }

        $whereSql = implode(' AND ', $whereClauses);

        $sql = "SELECT i.*, r.room_number, r.title as room_title, b.name as branch_name,
                       t.full_name as tenant_name, t.phone as tenant_phone
                FROM invoices i
                JOIN rooms r ON i.room_id = r.id
                JOIN branches b ON r.branch_id = b.id
                JOIN tenants t ON i.tenant_id = t.id
                WHERE {$whereSql}
                ORDER BY i.year DESC, i.month DESC, i.id DESC";

        return $this->query($sql, $params);
    }

    /**
     * Chi tiết 1 hóa đơn
     */
    public function getDetailsById(int $id): ?array {
        $sql = "SELECT i.*, r.room_number, r.title as room_title,
                       b.name as branch_name, b.address as branch_address, b.manager_name, b.manager_phone,
                       t.full_name as tenant_name, t.phone as tenant_phone, t.email as tenant_email,
                       c.contract_number
                FROM invoices i
                JOIN rooms r ON i.room_id = r.id
                JOIN branches b ON r.branch_id = b.id
                JOIN tenants t ON i.tenant_id = t.id
                JOIN contracts c ON i.contract_id = c.id
                WHERE i.id = :id
                LIMIT 1";
        return $this->queryOne($sql, [':id' => $id]);
    }

    /**
     * Lấy các dòng chi tiết của hóa đơn
     */
    public function getItems(int $invoiceId): array {
        $sql = "SELECT * FROM invoice_details WHERE invoice_id = :iid ORDER BY id ASC";
        return $this->query($sql, [':iid' => $invoiceId]);
    }

    /**
     * Lấy danh sách hóa đơn của khách thuê
     */
    public function getByTenantId(int $tenantId): array {
        $sql = "SELECT i.*, r.room_number, b.name as branch_name
                FROM invoices i
                JOIN rooms r ON i.room_id = r.id
                JOIN branches b ON r.branch_id = b.id
                WHERE i.tenant_id = :tid
                ORDER BY i.year DESC, i.month DESC, i.id DESC";
        return $this->query($sql, [':tid' => $tenantId]);
    }

    /**
     * Thống kê doanh thu theo 12 tháng của năm (Dành cho biểu đồ Chart.js)
     */
    public function getMonthlyRevenueChart(int $year): array {
        $sql = "SELECT month, 
                       SUM(CASE WHEN status = 'paid' THEN total_amount ELSE 0 END) as paid_amount,
                       SUM(CASE WHEN status = 'unpaid' THEN total_amount ELSE 0 END) as unpaid_amount,
                       SUM(total_amount) as total_amount
                FROM invoices
                WHERE year = :year
                GROUP BY month
                ORDER BY month ASC";
        $rows = $this->query($sql, [':year' => $year]);

        // Tạo mảng chuẩn 12 tháng
        $result = [];
        for ($m = 1; $m <= 12; $m++) {
            $result[$m] = [
                'month' => "T$m",
                'paid' => 0,
                'unpaid' => 0,
                'total' => 0
            ];
        }

        foreach ($rows as $row) {
            $m = (int)$row['month'];
            if (isset($result[$m])) {
                $result[$m]['paid'] = (float)$row['paid_amount'];
                $result[$m]['unpaid'] = (float)$row['unpaid_amount'];
                $result[$m]['total'] = (float)$row['total_amount'];
            }
        }

        return array_values($result);
    }
}
