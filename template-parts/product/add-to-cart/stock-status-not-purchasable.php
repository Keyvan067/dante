<?php

use Random\RandomException;

defined('ABSPATH') || exit;
$product = $args['product'] ?? null;
if (!$product || !is_a($product, 'WC_Product')) {
    return;
}
$product_id = $product->get_id();
// تعریف تابع تولید داده نمونه (قبل از استفاده)
if (!function_exists('generate_sample_price_history')) {
    /**
     * @throws RandomException
     */
    function generate_sample_price_history(): array
    {
        $data = [];
        $base = 10000000; // 10 میلیون

        for ($i = 11; $i >= 0; $i--) {
            $date = date('Y-m-d', strtotime("-$i months"));
            $price = $base + random_int(-5000000, 5000000);
            $data[] = [
                'date' => $date,
                'price' => max(100000, $price) // حداقل 1 میلیون
            ];
        }

        return $data;
    }
}
// دریافت تاریخچه قیمت از متا
$price_history = get_post_meta($product_id, '_price_history', true);
// اگه تاریخچه نبود یا خالی بود، از داده نمونه استفاده کن
if (empty($price_history) || !is_array($price_history)) {
    try {
        $price_history = generate_sample_price_history();
    } catch (RandomException $e) {
        error_log($e->getMessage());
    }
}
// آخرین قیمت
$last_record = !empty($price_history) ? $price_history[0] : null;
$last_price = $last_record ? $last_record['price'] : 0;
$last_date = $last_record ? $last_record['date'] : current_time('mysql');
// آماده‌سازی داده برای چارت
$chart_categories = [];
$chart_data = [];
if (!empty($price_history) && is_array($price_history)) {
    foreach (array_slice($price_history, 0, 12) as $record) {
        if (isset($record['date'], $record['price'])) {
            $chart_categories[] = helpers()->date()->jdate('Y/m/d', strtotime($record['date']));
            $chart_data[] = (float)$record['price'];
        }
    }
}
// برعکس کردن برای نمایش از قدیم به جدید
$chart_categories = array_reverse($chart_categories);
$chart_data = array_reverse($chart_data);
?>
<style>
    div:has(> .ag-charts-wrapper),
    ag-charts,
    ag-financial-charts {
        padding: 0 !important;
        border: none !important;
    }
</style>
<div class="product-card-not-purchasable">
    <div class="purchasable-wrapper">
        <div class="purchasable-chart">
            <div style="width: 100%; max-height: 170px;" id="chart-<?php echo $product_id; ?>"></div>
        </div>
        <div class="purchasable-info">
            <div>
                <svg width="80px" height="80px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path stroke="var(--color-base-300)" d="M3.17004 7.43994L12 12.5499L20.77 7.46991"
                          stroke-width="1.5"
                          stroke-linecap="round" stroke-linejoin="round"/>
                    <path stroke="var(--color-base-300)" d="M12 21.6099V12.5399" stroke-width="1.5"
                          stroke-linecap="round"
                          stroke-linejoin="round"/>
                    <path stroke="var(--color-base-300)" stroke-width="1.5" stroke-linecap="round"
                          stroke-linejoin="round"
                          d="M21.61 9.17V14.83C21.61 14.88 21.61 14.92 21.6 14.97C20.9 14.36 20 14 19 14C18.06 14 17.19 14.33 16.5 14.88C15.58 15.61 15 16.74 15 18C15 18.75 15.21 19.46 15.58 20.06C15.67 20.22 15.78 20.37 15.9 20.51L14.07 21.52C12.93 22.16 11.07 22.16 9.92999 21.52L4.59 18.56C3.38 17.89 2.39001 16.21 2.39001 14.83V9.17C2.39001 7.79 3.38 6.11002 4.59 5.44002L9.92999 2.48C11.07 1.84 12.93 1.84 14.07 2.48L19.41 5.44002C20.62 6.11002 21.61 7.79 21.61 9.17Z"/>
                    <path stroke="var(--color-base-300)" stroke-width="1.5" stroke-miterlimit="10"
                          stroke-linecap="round"
                          stroke-linejoin="round"
                          d="M23 18C23 19.2 22.47 20.27 21.64 21C20.93 21.62 20.01 22 19 22C16.79 22 15 20.21 15 18C15 16.74 15.58 15.61 16.5 14.88C17.19 14.33 18.06 14 19 14C21.21 14 23 15.79 23 18Z"/>
                    <path stroke="var(--color-base-300)" d="M19.25 16.75V18.25L18 19" stroke-width="1.5"
                          stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </div>
            <div class="purchasable-price">
                <div class="purchasable-update-price">
                    <span class="text-muted">آخرین بروزرسانی قیمت</span>
                    <span><?php echo helpers()->date()->jdate('Y/m/d', strtotime($last_date)); ?></span>
                </div>
                <div class="purchasable-last-price">
                    <span class="text-muted">آخرین قیمت ثبت شده</span>
                    <div>
                        <span class="regular-price"><?php echo number_format($last_price); ?></span>
                        <span class="currency-symbol currency-irr"></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="purchased-contact">
        <div>
            <span class="text-muted text-sm">شماره تماس </span>
            <span class="h1_title text-xl">0913000000</span>
        </div>
        <a href="tel:0913000000" class="purchased-contact__href">
            تماس با کارشناس فروش
        </a>
    </div>
</div>
<!-- ApexCharts -->
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // بررسی لود ApexCharts
        if (typeof ApexCharts === 'undefined') {
            return;
        }
        var chartElement = document.querySelector("#chart-<?php echo $product_id; ?>");
        if (!chartElement) {
            return;
        }
        var chartData = <?php echo json_encode($chart_data); ?>;
        var chartCategories = <?php echo json_encode($chart_categories); ?>;

        if (!chartData || chartData.length === 0) {
            chartElement.innerHTML = '<p class="text-gray-500 text-center p-4">داده‌ای برای نمایش وجود ندارد</p>';
            return;
        }
        var options = {
            series: [{
                name: 'قیمت',
                data: chartData
            }],
            chart: {
                height: 170,
                type: 'line',
                stacked: false,
                zoom: {enabled: false},
                toolbar: {show: false},
            },
            colors: ['#e60645', '#E91E63'],
            xaxis: {
                categories: chartCategories,
                labels: {
                    show: false
                },
                axisBorder: {show: false},
                axisTicks: {show: false}
            },
            yaxis: {
                labels: {
                    // formatter: function(value) {
                    //     return value.toLocaleString('fa-IR');
                    // }
                    show: false
                },
                axisBorder: {show: false},
                axisTicks: {show: false}
            },
            stroke: {
                width: 3,
                curve: "smooth",
                // curve: 'straight',
                dashArray: 7
            },
            grid: {
                show: false,
                // row: {
                //     colors: ['#f3f3f3', 'transparent'], // takes an array which will be repeated on columns
                //     opacity: 0.5
                // },
            },
        };

        try {
            var chart = new ApexCharts(chartElement, options);
            chart.render().then(function () {
                //console.log('✅ چارت با موفقیت رندر شد');
            }).catch(function (error) {
                //console.error('❌ خطا در رندر چارت:', error);
            });
        } catch (error) {
            //console.error('❌ خطا در ساخت چارت:', error);
        }
    });
</script>