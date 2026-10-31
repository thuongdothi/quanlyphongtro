// ==============================================================
// JAVASCRIPT ADMIN DASHBOARD: CHART.JS & TIỆN ÍCH QUẢN TRỊ
// ==============================================================

document.addEventListener('DOMContentLoaded', function () {
    // 1. Khởi tạo Biểu đồ Doanh thu (Chart.js) nếu có canvas
    const chartCanvas = document.getElementById('revenueChartCanvas');
    if (chartCanvas && typeof Chart !== 'undefined') {
        const chartDataRaw = JSON.parse(chartCanvas.dataset.chartJson || '[]');
        
        const labels = chartDataRaw.map(item => item.month);
        const paidData = chartDataRaw.map(item => item.paid);
        const unpaidData = chartDataRaw.map(item => item.unpaid);

        new Chart(chartCanvas, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [
                    {
                        label: 'Đã thu tiền (VNĐ)',
                        data: paidData,
                        backgroundColor: '#10b981',
                        borderRadius: 6,
                        stack: 'revenue'
                    },
                    {
                        label: 'Chưa thu tiền (VNĐ)',
                        data: unpaidData,
                        backgroundColor: '#ef4444',
                        borderRadius: 6,
                        stack: 'revenue'
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'top',
                        labels: {
                            font: { family: "'Plus Jakarta Sans', sans-serif", weight: '600' }
                        }
                    },
                    tooltip: {
                        callbacks: {
                            label: function (context) {
                                let val = context.raw || 0;
                                return context.dataset.label + ': ' + val.toLocaleString('vi-VN') + ' đ';
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function (val) {
                                return (val / 1000000).toFixed(0) + ' Tr';
                            }
                        }
                    }
                }
            }
        });
    }

    // 2. Nút xác nhận xóa (Confirm delete)
    document.querySelectorAll('.btn-confirm-delete').forEach(btn => {
        btn.addEventListener('click', function (e) {
            if (!confirm('Bạn có chắc chắn muốn xóa mục này? Hành động này không thể hoàn tác!')) {
                e.preventDefault();
            }
        });
    });

    // 3. Tự động tính tiền điện nước ở form nhập chỉ số
    const oldElecInput = document.getElementById('old_electricity');
    const newElecInput = document.getElementById('new_electricity');
    const elecConsumedEl = document.getElementById('elec_consumed_calc');

    function updateElecCalc() {
        if (oldElecInput && newElecInput && elecConsumedEl) {
            const oldVal = parseInt(oldElecInput.value) || 0;
            const newVal = parseInt(newElecInput.value) || 0;
            const diff = Math.max(0, newVal - oldVal);
            elecConsumedEl.textContent = diff + ' kWh';
        }
    }

    if (oldElecInput && newElecInput) {
        oldElecInput.addEventListener('input', updateElecCalc);
        newElecInput.addEventListener('input', updateElecCalc);
    }
});
