<div class="w-full flex items-center justify-start py-2">
    <span class="text-rotate">
        <span class="text-right">
             <?php
             $ticker_items = array(
                 array(
                     'text' => ' در سبد خرید ۱۰۰+ نفر ',
                     'icon' => '🛒',
                     'color' => 'text-emerald-600'
                 ),
                 array(
                     'text' => ' ۱۰۰۰ + بازدید در ۲۴ ساعت اخیر ',
                     'icon' => '♻️',
                     'color' => 'text-sky-500'
                 ),
                 array(
                     'text' => '۵۰۰+ نفر به این کالا علاقه دارند',
                     'icon' => '📐',
                     'color' => 'text-orange-500'
                 )
             );
             foreach ($ticker_items
                      as $item):
                 ?>
                 <div class="flex flex-row items-center justify-start gap-2">
                     <span class="leading-none"><?php echo esc_html($item['icon']); ?></span>
                     <span class=" text-sm <?php echo $item['color']; ?>"><?php echo esc_html($item['text']); ?></span>
                 </div>
             <?php endforeach; ?>
        </span>
    </span>
</div>