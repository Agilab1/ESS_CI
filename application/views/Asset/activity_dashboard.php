<style>
    body {
        overflow-x: hidden;
    }

    .row {
        margin-left: 0;
        margin-right: 0;
    }

    canvas {
        max-width: 100% !important;
        height: auto !important;
    }
</style>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    /* ===== PIE SLICE TEXT ===== */
    Chart.register({
        id: 'sliceText',
        afterDraw(chart) {
            if (chart.tooltip && chart.tooltip.opacity === 1) return;
            if (chart.config.type !== 'pie') return;

            const {
                ctx
            } = chart;
            const dataset = chart.data.datasets[0];
            const meta = chart.getDatasetMeta(0);

            ctx.save();
            ctx.fillStyle = '#fff';
            ctx.font = 'bold 16px Arial';
            ctx.textAlign = 'center';
            ctx.textBaseline = 'middle';

            meta.data.forEach((slice, i) => {
                if (dataset.data[i] > 0) {
                    const {
                        x,
                        y
                    } = slice.tooltipPosition();
                    ctx.fillText(chart.data.labels[i], x, y);
                }
            });
            ctx.restore();
        }
    });
</script>

<div class="container-fluid px-2">

    <!-- ===== SUMMARY ===== -->
    <div class="row mb-4 text-center">
        <div class="col-md-4 mb-2">
            <div class="card shadow">
                <div class="card-body">
                    <h6 class="text-primary">Total Assets</h6>
                    <h3 id="totalAsset">0</h3>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-2">
            <div class="card shadow">
                <div class="card-body">
                    <h6 class="text-success">Verified Assets</h6>
                    <h3 id="verifiedAsset">0</h3>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-2">
            <div class="card shadow">
                <div class="card-body">
                    <h6 class="text-danger">Unverified Assets</h6>
                    <h3 id="unverifiedAsset">0</h3>
                </div>
            </div>
        </div>
    </div>

    <!-- ===== SITE FILTER ===== -->
    <div class="row mb-3">
        <div class="col-md-4">
            <select id="siteFilter" class="form-control">
                <option value="">All Sites</option>
                <?php foreach ($sites as $s): ?>
                    <option value="<?= $s->site_id ?>"><?= $s->site_name ?></option>
                <?php endforeach; ?>
            </select>
        </div>
    </div>

    <!-- ===== PIE | LINE + POLL ===== -->
    <div class="row mb-4">

        <!-- LEFT : PIE -->
        <div class="col-md-6 mb-3">
            <div class="card shadow h-100">
                <div class="card-header fw-bold text-primary">
                    Verified vs Unverified (Pie)
                </div>
                <div class="card-body text-center">
                    <canvas id="verifyPie"></canvas>
                </div>
            </div>
        </div>

        <!-- RIGHT : LINE (TOP) + POLL (BOTTOM) -->
        <div class="col-md-6 mb-3">

            <!-- LINE -->
            <div class="card shadow mb-3">
                <div class="card-header fw-bold text-primary">
                    Verified Timeline
                </div>
                <div class="card-body">
                    <canvas id="verifyLine"></canvas>
                </div>
            </div>

            <!-- POLL / PILLAR -->
            <div class="card shadow">
                <div class="card-header fw-bold text-primary">
                    Verification Poll
                </div>
                <div class="card-body">
                    <canvas id="verifyPollBar"></canvas>
                </div>
            </div>

        </div>
    </div>
</div>

<script>
    let verifyPieChart, verifyLineChart, verifyPollBarChart;

    let pieAnimatedOnce = false;

    const pieEl = document.getElementById('verifyPie');
    const lineEl = document.getElementById('verifyLine');
    const pollEl = document.getElementById('verifyPollBar');

    function loadVerifyCharts() {

        const siteId = document.getElementById('siteFilter').value || '';

        fetch('<?= base_url("Asset/asset_verify_chart_ajax") ?>?site_id=' + siteId)
            .then(r => r.json())
            .then(d => {

                // ===== COUNTS =====
                totalAsset.innerText = d.total;
                verifiedAsset.innerText = d.verified;
                unverifiedAsset.innerText = d.unverified;

                /* ===== PIE ===== */
                if (verifyPieChart) verifyPieChart.destroy();
                verifyPieChart = new Chart(pieEl, {
                    type: 'pie',
                    data: {
                        labels: ['Verified', 'Unverified'],
                        datasets: [{
                            data: [d.verified, d.unverified],
                            backgroundColor: ['#198754', '#dc3545'],
                            radius: '60%'
                        }]
                    },
                    options: {
                        animation: pieAnimatedOnce ? false : {
                            animateRotate: true,
                            duration: 900,
                            easing: 'easeOutQuart'
                        }
                    }
                });
                pieAnimatedOnce = true;

                /* ===== LINE ===== */
                if (verifyLineChart) verifyLineChart.destroy();
                verifyLineChart = new Chart(lineEl, {
                    type: 'line',
                    data: {
                        labels: d.timeline.map(x => x.time),
                        datasets: [{
                            label: 'Verified',
                            data: d.timeline.map(x => x.verified),
                            borderColor: '#198754',
                            backgroundColor: '#198754',
                            tension: 0.3,
                            fill: false
                        }]
                    }
                });

                /* ===== POLL / PILLAR ===== */
                if (verifyPollBarChart) verifyPollBarChart.destroy();
                verifyPollBarChart = new Chart(pollEl, {
                    type: 'bar',
                    data: {
                        labels: ['Verified', 'Unverified'],
                        datasets: [{
                            data: [d.verified, d.unverified],
                            backgroundColor: ['#198754', '#dc3545'],
                            borderRadius: 8,
                            barThickness: 55
                        }]
                    },
                    options: {
                        responsive: true,
                        scales: {
                            y: {
                                beginAtZero: true,
                                max: d.total,
                                ticks: {
                                    precision: 0
                                }
                            }
                        },
                        plugins: {
                            legend: {
                                display: false
                            },
                            tooltip: {
                                callbacks: {
                                    label: ctx => ctx.raw + ' Assets'
                                }
                            }
                        }
                    }
                });
            });
    }

    document.getElementById('siteFilter').addEventListener('change', loadVerifyCharts);
    loadVerifyCharts();
    setInterval(loadVerifyCharts, 2000);
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>