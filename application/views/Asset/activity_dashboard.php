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

    <!-- SUMMARY -->
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
                    <h3 id="verifiedAsset" style="cursor:pointer">0</h3>
                </div>
            </div>
        </div>

        <div class="col-md-4 mb-2">
            <div class="card shadow">
                <div class="card-body">
                    <h6 class="text-danger">Unverified Assets</h6>
                    <h3 id="unverifiedAsset" style="cursor:pointer">0</h3>
                </div>
            </div>
        </div>
    </div>

    <!-- SITE FILTER -->
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

    <!-- CHARTS -->
    <div class="row mb-4">
        <div class="col-md-6 mb-3">
            <div class="card shadow h-100">
                <div class="card-header fw-bold text-primary">Verified vs Unverified (Pie)</div>
                <div class="card-body text-center">
                    <canvas id="verifyPie"></canvas>
                </div>
            </div>
        </div>

        <div class="col-md-6 mb-3">
            <div class="card shadow mb-3">
                <div class="card-header fw-bold text-primary">Verified Timeline</div>
                <div class="card-body">
                    <canvas id="verifyLine"></canvas>
                </div>
            </div>

            <div class="card shadow">
                <div class="card-header fw-bold text-primary">Verification Poll</div>
                <div class="card-body">
                    <canvas id="verifyPollBar"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- ASSET LIST -->
    <div class="row mt-4 d-none" id="assetListSection">
        <div class="col-12">
            <div class="card shadow">
                <div class="card-header fw-bold text-primary" id="assetListTitle"></div>
                <div class="card-body p-0">
                    <table class="table table-bordered table-striped mb-0">
                        <thead class="table-primary text-center">
                            <tr>
                                <th>#</th>
                                <th>Asset Name</th>
                                <th>Serial No</th>
                                <th>Site</th>
                            </tr>
                        </thead>
                        <tbody id="assetListBody"></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

</div>

<script>
    let verifyPieChart, verifyLineChart, verifyPollBarChart;
    let activeListFilter = null; // 1 = verified, 0 = unverified

    const pieEl = document.getElementById('verifyPie');
    const lineEl = document.getElementById('verifyLine');
    const pollEl = document.getElementById('verifyPollBar');

    function loadVerifyCharts() {

        const siteId = siteFilter.value || '';

        fetch('<?= base_url("Asset/asset_verify_chart_ajax") ?>?site_id=' + siteId)
            .then(r => r.json())
            .then(d => {

                totalAsset.innerText = d.total;
                verifiedAsset.innerText = d.verified;
                unverifiedAsset.innerText = d.unverified;

                verifyPieChart?.destroy();
                verifyPieChart = new Chart(pieEl, {
                    type: 'pie',
                    data: {
                        labels: ['Verified', 'Unverified'],
                        datasets: [{
                            data: [d.verified, d.unverified],
                            backgroundColor: ['#198754', '#dc3545'],
                            radius: '60%'
                        }]
                    }
                });

                verifyLineChart?.destroy();
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

                verifyPollBarChart?.destroy();
                verifyPollBarChart = new Chart(pollEl, {
                    type: 'bar',
                    data: {
                        labels: ['Verified', 'Unverified'],
                        datasets: [{
                            data: [d.verified, d.unverified],
                            backgroundColor: ['#198754', '#dc3545'],
                            barThickness: 55
                        }]
                    },
                    options: {
                        plugins: {
                            legend: {
                                display: false
                            }
                        },
                        scales: {
                            y: {
                                beginAtZero: true,
                                max: d.total
                            }
                        }
                    }
                });
                if (activeListFilter !== null) {
                    loadAssetList(activeListFilter, true);
                }
            });
    }

    function loadAssetList(verified, silent = false) {

        activeListFilter = verified;

        const siteId = siteFilter.value || '';

        fetch('<?= base_url("Asset/asset_list_by_verify_ajax") ?>?verified=' + verified + '&site_id=' + siteId)
            .then(r => r.json())
            .then(list => {

                assetListTitle.innerText =
                    verified == 1 ? 'Verified Assets' : 'Unverified Assets';

                let html = '';
                list.forEach((a, i) => {
                    html += `<tr>
                    <td class="text-center">${i+1}</td>
                    <td>${a.asset_name}</td>
                    <td>${a.serial_no}</td>
                    <td>${a.site_name}</td>
                </tr>`;
                });

                assetListBody.innerHTML =
                    html || `<tr><td colspan="4" class="text-center">No assets</td></tr>`;

                assetListSection.classList.remove('d-none');
                if (!silent) assetListSection.scrollIntoView({
                    behavior: 'smooth'
                });
            });
    }

    verifiedAsset.onclick = () => loadAssetList(1);
    unverifiedAsset.onclick = () => loadAssetList(0);

    siteFilter.onchange = () => {
        activeListFilter = null;
        assetListSection.classList.add('d-none');
        loadVerifyCharts();
    };

    loadVerifyCharts();
    setInterval(loadVerifyCharts, 2000);
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>