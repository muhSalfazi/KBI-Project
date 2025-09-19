// --- VARIABEL GLOBAL UNTUK SLIDESHOW & GRAFIK ---
let chartObjects = {};
let allCustomers = [];
let currentCustomerIndex = 0;
const customerTitleDisplay = document.getElementById("customer-title-display");
document.addEventListener("DOMContentLoaded", function () {
    document.getElementById("footer-year").textContent =
        new Date().getFullYear();

    const selectedText =
        customerSelect.options[customerSelect.selectedIndex].text;
    customerTitleDisplay.textContent = selectedText;

    const chartData = window.chartData;
    const dataActual = window.dataActual;
    const dataPlan = window.dataPlan;
    renderAllCharts(chartData);
    updateKpiCards(dataActual, dataPlan);

    const themeToggle = document.getElementById("checkbox");
    const currentTheme = localStorage.getItem("theme");
    if (currentTheme === "dark") {
        document.body.classList.add("dark-mode");
        themeToggle.checked = true;
    }
    themeToggle.addEventListener("change", function () {
        if (this.checked) {
            document.body.classList.add("dark-mode");
            localStorage.setItem("theme", "dark");
        } else {
            document.body.classList.remove("dark-mode");
            localStorage.setItem("theme", "light");
        }
        fetchCurrentCustomerData();
    });
});

customerSelect.addEventListener("change", function () {
    const selectedText =
        customerSelect.options[customerSelect.selectedIndex].text;
    customerTitleDisplay.textContent = selectedText;
    applyFilter();
});

dateFilter.addEventListener("change", function () {
    applyFilter();
});

const today = new Date().toISOString().split("T")[0];

function applyFilter() {
    const selectedCustomer = customerSelect.value;
    const selectedDate = dateFilter.value;
    const heroRoute = window.g_heroRoute;
    const newUrl = `${heroRoute}?customer=${selectedCustomer}&date=${selectedDate}`;

    window.location.href = newUrl;
}

function handleResponse(response) {
    document.getElementById("loader").style.display = "none";
    document.getElementById("mainDashboard").style.opacity = "1";

    if (!response || !response.kpis || !response.charts) {
        showError({
            message: "Data yang diterima dari server tidak valid.",
        });
        return;
    }
    updateKpiCards(response.kpis);
    renderAllCharts(response.charts);
}

function updateKpiCards(kpis, plan) {
    document.getElementById("order-actual").textContent = kpis.admin;
    document.getElementById("order-plan").textContent = plan.planDN;
    if (kpis.admin != plan.planDN) {
        document.getElementById("order-actual").classList.add("mismatch");
    }
    document.getElementById("order-pending").textContent =
        Math.max(parseInt(plan.planDN) - parseInt(kpis.admin), 0) +
        " Manifest/DN belum Posting";

    document.getElementById("prepare-actual").textContent = kpis.prepare;
    document.getElementById("prepare-plan").textContent = plan.planPcs;
    if (kpis.prepare != plan.planPcs) {
        document.getElementById("prepare-actual").classList.add("mismatch");
    }
    document.getElementById("prepare-pending").textContent =
        Math.max(parseInt(plan.planPcs) - parseInt(kpis.prepare), 0) +
        " Pcs belum di-Prepare";

    document.getElementById("leader-actual").textContent = kpis.leader;
    document.getElementById("leader-plan").textContent = plan.planPcs;
    if (kpis.leader != plan.planPcs) {
        document.getElementById("leader-actual").classList.add("mismatch");
    }
    document.getElementById("leader-pending").textContent =
        Math.max(parseInt(plan.planPcs) - parseInt(kpis.leader), 0) +
        " Pcs belum di-Check";

    document.getElementById("docCheck-actual").textContent = kpis.document;
    document.getElementById("docCheck-plan").textContent = plan.planDN;
    if (kpis.document != plan.planDN) {
        document.getElementById("docCheck-actual").classList.add("mismatch");
    }
    document.getElementById("docCheck-pending").textContent =
        Math.max(parseInt(plan.planDN) - parseInt(kpis.document), 0) +
        " Manifest/DN belum Loading";

    document.getElementById("loading-actual").textContent = kpis.load;
    document.getElementById("loading-plan").textContent = plan.planPcs;
    if (kpis.load != plan.planPcs) {
        document.getElementById("loading-actual").classList.add("mismatch");
    }
    document.getElementById("loading-pending").textContent =
        Math.max(parseInt(plan.planPcs) - parseInt(kpis.load), 0) +
        "  Pcs belum Loading";
}

function filterChartData(labels, actual, plan) {
    const filteredLabels = [];
    const filteredActual = [];
    const filteredPlan = plan ? [] : null;

    // Loop untuk memfilter data
    for (let i = 0; i < labels.length; i++) {
        // Ambil nilai plan untuk dijadikan dasar filter
        const planValue = plan[i] || 0;

        // Memeriksa apakah nilai plan lebih besar dari 0
        if (planValue > 0) {
            filteredLabels.push(`Cycle-${labels[i]}`);

            // Mengisi filteredActual dengan nilai dari array 'actual'
            filteredActual.push(actual[i] || 0);

            // Mengisi filteredPlan dengan nilai dari array 'plan'
            if (plan) filteredPlan.push(planValue);
        }
    }
    return {
        labels: filteredLabels,
        actual: filteredActual,
        plan: filteredPlan,
    };
}
let currentState = "pending";
function renderAllCharts(chartData) {
    // --- Grafik Order ---
    const orderData = filterChartData(
        chartData.labels,
        chartData.order.actual,
        chartData.order.plan
    );
    updateOrCreateChart(
        "orderChart",
        orderData.labels,
        orderData.plan,
        orderData.actual
    );

    // --- Grafik Prepare ---
    const prepareData = filterChartData(
        chartData.labels,
        chartData.prepare.actual,
        chartData.prepare.plan
    );
    updateOrCreateChart(
        "prepareChart",
        prepareData.labels,
        prepareData.plan,
        prepareData.actual
    );

    // --- Grafik Leader Check ---
    const leaderData = filterChartData(
        chartData.labels,
        chartData.leaderCheck.actual,
        chartData.leaderCheck.plan
    );
    updateOrCreateChart(
        "leaderCheckChart",
        leaderData.labels,
        leaderData.plan,
        leaderData.actual
    );

    // --- Grafik Doc Check ---
    const docData = filterChartData(
        chartData.labels,
        chartData.docCheck.actual,
        chartData.docCheck.plan
    );
    updateOrCreateChart(
        "docCheckChart",
        docData.labels,
        docData.plan,
        docData.actual
    );

    // --- Grafik Loading ---
    const loadingData = filterChartData(
        chartData.labels,
        chartData.loading.actual,
        chartData.loading.plan
    );
    updateOrCreateChart(
        "loadingChart",
        loadingData.labels,
        loadingData.plan,
        loadingData.actual
    );
}

function updateOrCreateChart(canvasId, labels, planData, actualData) {
    const ctx = document.getElementById(canvasId).getContext("2d");

    // Hancurkan grafik yang sudah ada untuk menghindari tumpang tindih
    if (chartObjects[canvasId]) {
        chartObjects[canvasId].destroy();
    }

    // --- LOGIKA BARU UNTUK WARNA BARIS GANDA ---
    const actualBackgroundColors = actualData.map((actualValue, index) => {
        const planValue = planData[index];
        const isCompleted = actualValue >= planValue && planValue > 0;
        return isCompleted ? "#16a34a" : "#f7b801"; // Hijau untuk selesai, Biru untuk belum
    });

    const actualBorderColors = actualData.map((actualValue, index) => {
        const planValue = planData[index];
        const isCompleted = actualValue >= planValue && planValue > 0;
        return isCompleted ? "#16a34a" : "#f7b801";
    });

    // Karena warna label dan garis juga perlu disesuaikan
    const planLineColor = "#2658ffff"; // Hijau terang untuk Plan jika selesai
    const actualLineColor = "#2658ffff"; // Oranye untuk Actual jika belum selesai

    const isOverallCompleted =
        actualData.reduce((sum, value) => sum + value, 0) >=
            planData.reduce((sum, value) => sum + value, 0) &&
        planData.reduce((sum, value) => sum + value, 0) > 0;

    const finalPlanColor = isOverallCompleted ? planLineColor : "#f7b801";
    const finalActualColor = isOverallCompleted ? actualLineColor : "#FFA500";
    // --- AKHIR LOGIKA BARU ---

    // Buat instance Chart.js baru
    chartObjects[canvasId] = new Chart(ctx, {
        type: "bar",
        data: {
            labels: labels,
            datasets: [
                {
                    label: "Plan",
                    data: planData,
                    type: "line",
                    fill: false,
                    borderColor: finalPlanColor,
                    tension: 0.4,
                    pointRadius: 3,
                    pointBackgroundColor: finalPlanColor,
                    pointBorderColor: finalPlanColor,
                    order: 1,
                },
                {
                    label: "Actual",
                    data: actualData,
                    backgroundColor: actualBackgroundColors,
                    borderColor: actualBorderColors,
                    borderWidth: 1,
                    borderRadius: 4,
                    order: 2,
                },
            ],
        },
        options: {
            onClick: function (evt, elements) {
                if (elements.length > 0) {
                    let cycle = elements[0].index; // cycle
                    let kategori =
                        this.data.datasets[elements[0].datasetIndex].label; // kategori
                    let cardName = evt.chart.canvas.id; // card (pakai id canvas)

                    let params = new URLSearchParams({
                        cycle: cycle + 1,
                        kategori: kategori,
                        cardName: cardName,
                    });
                    console.log(cycle);

                    const route = window.g_modalTable;

                    fetch(`${route}?${params.toString()}`)
                        .then((res) => res.json()) // bisa juga .text() kalau return HTML
                        .then((data) => {
                            console.log(data);
                            const row = Array.isArray(data) ? data : [data];

                            gridManifest(row, cardName);
                            bootstrap.Modal.getOrCreateInstance(
                                document.getElementById("simpleModal")
                            ).show();
                        })
                        .catch((err) => console.error("Error:", err));
                }
            },
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false },
                datalabels: {
                    display: (context) =>
                        context.dataset.label === "Actual" &&
                        context.dataset.data[context.dataIndex] > 0,
                    anchor: "end",
                    align: "end",
                    offset: 10,
                    // --- Gunakan array warna juga untuk label ---
                    color: (context) => {
                        const actualValue =
                            context.dataset.data[context.dataIndex];
                        const planValue = planData[context.dataIndex];
                        const isCompleted =
                            actualValue >= planValue && planValue > 0;
                        return isCompleted ? "#16a34a" : "#000"; // Hijau untuk selesai, Hitam untuk belum
                    },
                    // ---
                    font: { weight: "bold" },
                },
                tooltip: {
                    enabled: true,
                    backgroundColor: "#111827",
                    titleColor: "#ffffff",
                    bodyColor: "#ffffff",
                },
            },
            scales: {
                y: { display: false, beginAtZero: true },
                x: { display: true, grid: { display: false } },
            },
        },
        plugins: [ChartDataLabels],
    });
}

function showError(error) {
    alert("Gagal memuat data dari server: " + error.message);
    document.getElementById("loader").style.display = "none";
    document.getElementById("mainDashboard").style.opacity = "1";
}

let agGridTable;
function gridManifest(data, cardName) {
    let statusHeader = "Status"; // default
    let kolom;

    if (cardName === "orderChart") {
        statusHeader = "Status Posting";
        kolom = "status";
    } else if (cardName === "docCheckChart") {
        statusHeader = "Status Surat Jalan";
        kolom = "check_sj";
    } else if (cardName === "leaderCheckChart") {
        statusHeader = "Status Leader Check";
        kolom = "check_leader";
    } else if (cardName === "prepareChart") {
        statusHeader = "Status Prepare";
        kolom = "status_label";
    } else if ((cardName = "loadingChart")) {
        statusHeader = "Status Loading";
        kolom = "check_loading";
    }

    const columnDefs = [
        {
            headerName: "DN No",
            field: "dn_no",
            sortable: true,
            filter: true,
            flex: 1,
        },
        {
            headerName: "Job No",
            field: "job_no",
            sortable: true,
            filter: true,
            flex: 1,
        },
        {
            headerName: "Cycle",
            field: "cycle",
            sortable: true,
            filter: true,
            flex: 1,
        },
        {
            headerName: "Part No",
            field: "part_no",
            sortable: true,
            filter: true,
            flex: 1,
        },
        {
            headerName: "Qty Order",
            field: "qty_pcs",
            sortable: true,
            filter: true,
            flex: 1,
        },
        {
            headerName: statusHeader,
            field: kolom,
            flex: 1,
            cellRenderer: (p) => {
                if (cardName === "orderChart") {
                    return p.value === "OK"
                        ? '<span class="badge bg-success">Close</span>'
                        : '<span class="badge bg-secondary">Open</span>';
                } else if (cardName === "docCheckChart") {
                    return p.value === 1
                        ? '<span class="badge bg-success">Close</span>'
                        : '<span class="badge bg-secondary">Open</span>';
                } else if (cardName === "leaderCheckChart") {
                    return p.value === 1
                        ? '<span class="badge bg-success">Close</span>'
                        : '<span class="badge bg-secondary">Open</span>';
                } else if (cardName === "prepareChart") {
                    return p.value === "Close"
                        ? '<span class="badge bg-success">Close</span>'
                        : '<span class="badge bg-secondary">Open</span>';
                } else if (cardName === "loadingChart") {
                    return p.value === 1
                        ? '<span class="badge bg-success">Close</span>'
                        : '<span class="badge bg-secondary">Open</span>';
                }
                return p.value;
            },
        },
        {
            headerName: "Tanggal Order",
            field: "tanggal_order",
            sortable: true,
            filter: true,
            flex: 1,
        },
    ];
    const gridOptions = {
        columnDefs: columnDefs,
        rowData: data,
        defaultColDef: {
            resizable: true,
        },
        pagination: true,
        paginationPageSize: 10,
    };

    // Hapus grid lama kalau sudah ada
    if (agGridTable) {
        agGridTable.destroy();
    }

    const gridDiv = document.getElementById("agGridTable");
    agGridTable = agGrid.createGrid(gridDiv, gridOptions);
}
