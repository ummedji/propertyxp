<?php ?>

<div class=row>
    <div class="col-sm-4">
        <?php $form->render(); ?>
    </div>

    <div class="col-sm-8">

        <div class="row">
            <div class="chart-area">
                <div class="col-md-6">
                    <div class="chart-wrapper">
                        <div id=doughnutChart class=chart></div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="chart-legend">
                        <?php foreach($data as $index => $item): ?>
                            <div class="legend-item <?php print $item['index']; ?>">
                                <span class="legend" style="background-color: <?php print $item['color']; ?>"></span>
                                <?php print $item['title']; ?>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <?php if (aviators_calculators_mt_setting('display_month_table')): ?>
                    <?php aviators_calculator_monthly_table($data); ?>
                <?php endif; ?>

                <?php if (aviators_calculators_mt_setting('display_year_table')): ?>
                    <?php aviators_calculator_yearly_table($data); ?>
                <?php endif; ?>

                <?php if (aviators_calculators_mt_setting('display_total_table')): ?>
                    <?php aviators_calculator_total_table($data); ?>
                <?php endif; ?>
            </div>
        </div>

    </div>
</div>

<script>
    jQuery("#doughnutChart").drawDoughnutChart(<?php echo $js_array; ?>,
        {
            sign: '<?php print aviators_calculators_mt_setting('currency'); ?>',
            summaryTitle: 'Monthly Payment'
        }
    );
</script>

