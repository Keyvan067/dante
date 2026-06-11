<?php
$product_rating = get_query_var('product_rating');
?>

<?php if ($product_rating > 0): ?>
    <div class="tooltip-sp">
        <div tooltip="<?php echo esc_attr(sprintf('امتیاز %s از 5', $product_rating)); ?>"
              flow="up"
              class="*:w-6 *:h-auto flex items-center justify-center gap-2 bg-accent rounded-xl px-4 py-3">
            <span>
<!--            --><?php
/*                for ($i = 1; $i <= $product_rating; $i++) {
                    echo '<i class="fa-solid fa-star"></i>';
                }
            */?>
            </span>
            <span class="!text-sm font-bold">
                <?php echo esc_html(number_format($product_rating, 1)); ?>
            </span>
        </div>
    </div>
<?php else: ?>
    <span class="flex-cc">
        <i class="fa-regular fa-star text-default font-bold fa-md"></i>
        <span>بدون امتیاز</span>
    </span>
<?php endif; ?>





<!--
<?php
/*$product_rating = get_query_var('product_rating');
*/?>

<?php /*if ($product_rating > 0): */?>
    <div class="product_rating">
        <div class="w-fit flex flex-row items-center justify-center gap-2 bg-accent rounded-full px-4 py-1">
            <span class="flex-cc gap-1 *:text-xs *:text-amber-500 flex-row">
            <?php
/*            for ($i = 1; $i <= $product_rating; $i++) {
                echo '<i class="fa-solid fa-star"></i>';
            }
            */?>
            </span>
            <span class="font-bold">
                <?php /*echo esc_html(number_format($product_rating, 1)); */?>
            </span>
        </div>
    </div>
<?php /*else: */?>
    <span class="flex-cc">
        <i class="fa-regular fa-star text-default"></i>
        <span>بدون امتیاز</span>
    </span>
--><?php /*endif; */?>
