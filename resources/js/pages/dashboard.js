import Chart from "chart.js/auto";
import colors from "../colors";
import {createIcons, icons} from "lucide";

let chart;
export const transactionStats = (reset = false) => {
    const transactionsChart = $("#transactions-chart");

    if (reset) chart.destroy();

    if (transactionsChart.length) {
        let ctx = transactionsChart[0].getContext("2d");
        chart = new Chart(ctx, {
            type: "bar",
            data: {
                labels: JSON.parse(transactionsChart.data('labels')),
                datasets: [
                    {
                        label: "Amount",
                        barThickness: 8,
                        maxBarThickness: 6,
                        data: JSON.parse(transactionsChart.data('values')),
                        backgroundColor: colors.info(0.9),
                    }
                ],
            },
            options: {
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false,
                    },
                },
                scales: {
                    x: {
                        ticks: {
                            font: {
                                size: 11,
                            },
                            color: colors.slate["500"](0.8),
                        },
                        grid: {
                            display: false,
                            drawBorder: false,
                        },
                    },
                    y: {
                        ticks: {
                            display: false,
                        },
                        grid: {
                            color: $("html").hasClass("dark")
                                ? colors.darkmode["300"](0.8)
                                : colors.slate["300"](),
                            borderDash: [2, 2],
                            drawBorder: false,
                        },
                    },
                },
            },
        });
    }
}

(function () {
    "use strict"

    const terminalChart = $("#terminal-donut-chart-3");

    if (terminalChart.length) {
        let ctx = terminalChart[0].getContext("2d");
        let myDoughnutChart = new Chart(ctx, {
            type: "doughnut",
            data: {
                labels: JSON.parse(terminalChart.data('labels')),
                datasets: [
                    {
                        data: JSON.parse(terminalChart.data('values')),
                        backgroundColor: [
                            colors.warning(0.9),
                            colors.success(0.9),
                        ],
                        hoverBackgroundColor: [
                            colors.warning(0.8),
                            colors.success(0.8),
                        ],
                        borderWidth: 5,
                        borderColor: $("html").hasClass("dark")
                            ? colors.darkmode[700]()
                            : colors.slate[200](),
                    },
                ],
            },
            options: {
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false,
                    },
                },
                cutout: "82%",
            },
        });
    }

    transactionStats();

    window.addEventListener("dashboard-transaction-chart", () => transactionStats(true) );
})()
