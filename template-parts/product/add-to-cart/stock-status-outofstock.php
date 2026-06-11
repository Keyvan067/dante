<?php
defined('ABSPATH') || exit;

$product = $args['product'] ?? null;

if (!$product || !is_a($product, 'WC_Product')) {
    return;
}

$product_id = $product->get_id();
$current_user = woo()->getCurrentUserInfo();

// دریافت اطلاعات داینامیک
$expected_date = woo()->getExpectedRestockDate($product_id);
$last_stock_date = woo()->getLastInStockDate($product_id);
$category_slug = woo()->getFirstCategorySlug($product_id);
$contact_url = woo()->getContactPageUrl();
$shop_category_url = woo()->getShopCategoryUrl($category_slug);
$privacy_url = get_privacy_policy_url() ?: home_url('/privacy');

// بررسی اینکه کاربر قبلاً درخواست داده؟
$has_requested = false; // این رو باید از دیتابیس چک کنی
?>

<!-- پیغام اصلی -->
<div class="w-full block mb-8 text-center">
    <div class="bg-base-200/50 rounded-xl p-6 border border-base-200">
        <i class="fa-regular fa-box-open fa-3x text-muted mb-4"></i>
        <h4 class="text-xl font-bold text-strong mb-2">این کالا فعلا موجود نیست</h4>
        <p class="text-muted text-sm">
            می‌توانید زنگوله را بزنید تا به محض موجود شدن،
            از طریق ایمیل یا پیامک به شما خبر دهیم.
        </p>

        <!-- اطلاعات تکمیلی -->
        <?php if (!empty($expected_date) || !empty($last_stock_date)): ?>
            <div class="mt-6 flex flex-col gap-3 text-sm text-strong/70">
                <?php if (!empty($expected_date)): ?>
                    <div class="flex items-center justify-center gap-2">
                        <i class="fa-regular fa-calendar-day"></i>
                        <span>پیش‌بینی موجودی: <?php echo esc_html($expected_date); ?></span>
                    </div>
                <?php endif; ?>

                <?php if (!empty($last_stock_date)): ?>
                    <div class="flex items-center justify-center gap-2">
                        <i class="fa-regular fa-history"></i>
                        <span>آخرین موجودی: <?php echo esc_html($last_stock_date); ?></span>
                    </div>
                <?php endif; ?>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php if ($has_requested): ?>
    <!-- پیام قبلاً درخواست داده -->
    <div class="bg-green-50 border border-green-200 rounded-lg p-4 text-center">
        <i class="fa-solid fa-check-circle text-green-500 text-2xl mb-2"></i>
        <h5 class="font-bold text-green-700 mb-1">درخواست شما ثبت شده است</h5>
        <p class="text-green-600 text-sm">
            به محض موجود شدن، به شما اطلاع خواهیم داد.
        </p>
    </div>
<?php else: ?>
    <!-- فرم ثبت درخواست -->
    <div class="w-full block">
        <h5 class="font-bold text-strong mb-4 text-center">
            <i class="fa-regular fa-bell text-amber-500 ml-2"></i>
            خبرم کنید وقتی موجود شد
        </h5>

        <form id="outOfStockNotifyForm" class="space-y-4" method="post">
            <?php wp_nonce_field('outofstock_notify', 'outofstock_nonce'); ?>
            <input type="hidden" name="product_id" value="<?php echo esc_attr($product_id); ?>">
            <input type="hidden" name="action" value="outofstock_notify">
            <!-- فیلد ایمیل -->
            <div class="block">
                <label class="block text-sm font-medium text-strong mb-1">
                    آدرس ایمیل <span class="text-red-500">*</span>
                </label>
                <input type="email"
                       name="email"
                       value="<?php echo is_user_logged_in() ? esc_attr($current_user['email']) : ''; ?>"
                    <?php echo is_user_logged_in() ? 'readonly' : ''; ?>
                       placeholder="example@gmail.com"
                       required
                       class="w-full px-4 py-3 border border-base-300 rounded-lg text-sm focus:ring focus:ring-sky-500 focus:border-sky-500 outline-none transition-all <?php echo is_user_logged_in() ? 'bg-gray-100 cursor-not-allowed' : ''; ?>">
                <?php if (is_user_logged_in()): ?>
                    <p class="text-xs text-strong mt-1">ایمیل شما از اطلاعات حساب شما خوانده می‌شود</p>
                <?php endif; ?>
            </div>
            <!-- فیلد شماره موبایل -->
            <div class="block">
                <label class="block text-sm font-medium text-strong mb-1">
                    شماره موبایل (اختیاری)
                </label>
                <input type="tel"
                       name="phone"
                       value="<?php echo is_user_logged_in() ? esc_attr($current_user['phone']) : ''; ?>"
                       placeholder="09xxxxxxxxx"
                       pattern="09[0-9]{9}"
                       class="w-full px-4 py-3 border border-base-300 rounded-lg text-sm focus:ring focus:ring-sky-500 focus:border-sky-500 outline-none transition-all">
                <p class="text-xs text-strong mt-1">برای اطلاع‌رسانی پیامکی</p>
            </div>

            <!-- دکمه ارسال -->
            <button type="submit" class="btn btn-warning !py-6 !w-full !text-md btn-soft border border-warning">
                <i class="fa-solid fa-bell-ring fa-lg"></i>
                <span>ثبت درخواست اطلاع‌رسانی</span>
            </button>
        </form>

        <?php if (!is_user_logged_in()): ?>
            <!-- لینک ورود برای مهمان‌ها -->
            <p class="text-xs text-strong mt-4 text-center">
                قبلاً ثبت‌نام کرده‌اید؟
                <a href="<?php echo esc_url(wp_login_url(get_permalink())); ?>" class="text-sky-500 hover:underline">
                    وارد شوید
                </a>
            </p>
        <?php endif; ?>
    </div>
<?php endif; ?>

<!-- لینک‌های جایگزین -->
<div class="w-full block mt-5">
    <h6 class="text-sm font-bold text-strong mb-3">گزینه‌های دیگر:</h6>
    <div class="grid grid-cols-2 gap-3">
        <a href="<?php echo esc_url($shop_category_url); ?>"
           class="flex flex-col items-center justify-center p-3 bg-blue-50 rounded-lg border border-blue-100 hover:bg-blue-100 transition-colors">
            <i class="fa-regular fa-clone text-blue-500 mb-1"></i>
            <span class="text-xs text-blue-700">محصولات مشابه</span>
        </a>
        <a href="<?php echo esc_url($contact_url); ?>"
           class="flex flex-col items-center justify-center p-3 bg-green-50 rounded-lg border border-green-100 hover:bg-green-100 transition-colors">
            <i class="fa-regular fa-headset text-green-500 mb-1"></i>
            <span class="text-xs text-green-700">پشتیبانی</span>
        </a>
    </div>
</div>

<!-- حریم خصوصی -->
<p class="text-xs text-strong mt-6 text-center">
    با ثبت اطلاعات، موافقت خود را با
    <a href="<?php echo esc_url($privacy_url); ?>" class="text-sky-500 hover:underline">
        قوانین حریم خصوصی
    </a>
    اعلام می‌کنید.
</p>

<!-- اسکریپت Ajax -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const notifyForm = document.getElementById('outOfStockNotifyForm');
        if (!notifyForm) return;

        notifyForm.addEventListener('submit', async function (e) {
            e.preventDefault();

            const formData = new FormData(this);
            const submitBtn = this.querySelector('button[type="submit"]');
            const originalHTML = submitBtn.innerHTML;

            submitBtn.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> در حال ارسال...';
            submitBtn.disabled = true;

            try {
                const response = await fetch('<?php echo esc_url(admin_url('admin-ajax.php')); ?>', {
                    method: 'POST',
                    body: formData
                });

                const data = await response.json();

                if (data.success) {
                    notifyForm.innerHTML = `
                    <div class="bg-green-50 border border-green-200 rounded-lg p-4 text-center">
                        <i class="fa-solid fa-check-circle text-green-500 text-2xl mb-2"></i>
                        <h5 class="font-bold text-green-700 mb-1">${data.data.message || 'با موفقیت ثبت شد!'}</h5>
                        <p class="text-green-600 text-sm">
                            به محض موجود شدن، به شما اطلاع خواهیم داد.
                        </p>
                    </div>
                `;
                } else {
                    alert(data.data.message || 'خطایی رخ داد. لطفا مجدد تلاش کنید.');
                    submitBtn.innerHTML = originalHTML;
                    submitBtn.disabled = false;
                }
            } catch (error) {
                console.error('Error:', error);
                alert('خطا در ارتباط با سرور');
                submitBtn.innerHTML = originalHTML;
                submitBtn.disabled = false;
            }
        });
    });
</script>