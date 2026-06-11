<?php
global $product;
$product = $product instanceof WC_Product ? $product : wc_get_product(get_the_ID());
if (!$product || !$product->is_type('variable')) {
    return;
}
// دریافت ویژگی‌ها از کلاس جدید
$attributes_data = woo()->getVariationAttributes($product);
// ===== حلقه روی همه ویژگی‌های متغیر =====
foreach ($attributes_data as $attribute):
    $taxonomy = $attribute['taxonomy'];
    $terms = $attribute['terms'];
    $default_value = $attribute['default_value'];
    $attribute_label = $attribute['label'];
    $attribute_type = $attribute['type'];
    ?>
    <!-- نمایش ویژگی -->
    <div class="product-variations-content">
        <div class="variation-header">
            <h5 class="h4_title">
                <?php echo esc_html($attribute_label); ?> :
                <span class="selected-<?php echo esc_attr(str_replace('pa_', '', $taxonomy)); ?>">
                    <?php echo esc_html($default_value); ?>
                </span>
            </h5>
        </div>
        <div class="custom-attribute-option hide-scrollbar">
            <?php foreach ($terms as $term):
                if (!is_object($term)) continue;

                $is_active = $term->slug === $default_value;
                $hex = woo()->getTermColor($term->term_id);

                if ($attribute_type === 'color'):
                    $border_white = '';
                    if (!empty($hex)) {
                        if ($hex == '#ffffff' || $hex == '#fff') {
                            $border_white = ' border border-base-300 ';
                        } else {
                            $border_white = '';
                        }
                    }
                    ?>
                    <span data-attribute="<?php echo esc_attr($taxonomy); ?>"
                          data-value="<?php echo esc_attr($term->slug); ?>"
                          data-label="<?php echo esc_attr($term->name); ?>"
                          title="<?php echo esc_attr($term->name); ?>"
                          class="product-colors-var
                          <?php
                          echo $is_active ?
                              ' active !ring-2 !ring-sky-500' :
                              'ring ring-slate-300 ';
                          echo esc_attr($border_white)
                          ?>"
                          style="background-color: <?php echo esc_attr($hex ?: '#cccccc'); ?>">
                    </span>
                <?php else: ?>
                    <span data-attribute="<?php echo esc_attr($taxonomy); ?>"
                          data-value="<?php echo esc_attr($term->slug); ?>"
                          data-label="<?php echo esc_attr($term->name); ?>"
                          class="product-other-var <?php echo $is_active ? 'active !ring-2 !ring-sky-500' : 'ring ring-slate-300'; ?>"
                          title="<?php echo esc_attr($term->name); ?>">
                        <?php echo esc_html(strtoupper($term->name)); ?>
                    </span>
                <?php endif; ?>
            <?php endforeach; ?>
        </div>
    </div>
<?php endforeach; ?>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        var form = document.querySelector('.variations_form');
        if (!form || !form.dataset.product_variations) return;

        var variations;
        try {
            variations = JSON.parse(form.dataset.product_variations);
        } catch (e) {
            console.warn('خطا در خواندن اطلاعات محصول');
            return;
        }

        if (!Array.isArray(variations) || variations.length === 0) return;

        var validVariations = variations.filter(function (v) {
            return v &&
                v.is_in_stock === true &&
                v.display_price !== undefined &&
                v.display_price !== null &&
                v.attributes;
        });

        if (validVariations.length === 0) return;

        var options = document.querySelectorAll('[data-attribute][data-value]');
        if (options.length === 0) return;

        // ========== تشخیص ویژگی رنگ ==========
        function isColorAttribute(attr) {
            var colorOption = document.querySelector('[data-attribute="' + attr + '"].color-attribute');
            return attr.includes('color') || attr.includes('رنگ') || colorOption;
        }

        // ========== غیرفعال کردن رنگ‌های بدون ترکیب معتبر ==========
        function disableInvalidColors() {
            var colorOptions = document.querySelectorAll('[data-attribute*="color"], [data-attribute*="رنگ"]');

            colorOptions.forEach(function (opt) {
                var attr = opt.dataset.attribute;
                var value = opt.dataset.value;

                var hasValidCombination = validVariations.some(function (v) {
                    return v.attributes['attribute_' + attr] === value;
                });

                if (!hasValidCombination) {
                    opt.classList.add('disabled');
                    opt.setAttribute('aria-disabled', 'true');
                    opt.setAttribute('data-tooltip', 'این رنگ موجود نیست');
                } else {
                    opt.classList.remove('disabled');
                    opt.removeAttribute('aria-disabled');
                    opt.removeAttribute('data-tooltip');
                }
            });
        }

        function setSelect(attr, value) {
            updateActiveStates();
            var select = form.querySelector('select[name="attribute_' + attr + '"]');
            if (!select) return false;

            if (select.value === value) return true;

            select.value = value;
            select.dispatchEvent(new Event('change', {bubbles: true}));
            return true;
        }

        function updateDisplayText() {
            var selects = form.querySelectorAll('select[name^="attribute_"]');
            selects.forEach(function (select) {
                var attr = select.name.replace('attribute_', '');
                var selectedSpan = document.querySelector('.selected-' + attr.replace('pa_', ''));
                if (selectedSpan && select.value) {
                    var activeOption = document.querySelector('[data-attribute="' + attr + '"][data-value="' + select.value + '"]');
                    selectedSpan.textContent = activeOption?.dataset.label || select.value;
                }
            });
        }

        function resetOptions() {
            for (var i = 0; i < options.length; i++) {
                var opt = options[i];
                opt.classList.remove('disabled');
                opt.removeAttribute('aria-disabled');
                opt.removeAttribute('data-tooltip');
            }
            disableInvalidColors();
        }

        function filterOptions(selectedAttr, selectedValue) {
            resetOptions();

            var compatible = validVariations.filter(function (v) {
                return v.attributes['attribute_' + selectedAttr] === selectedValue;
            });

            if (compatible.length === 0) return;

            for (var i = 0; i < options.length; i++) {
                var opt = options[i];
                var attr = opt.dataset.attribute;
                var value = opt.dataset.value;

                if (isColorAttribute(attr)) continue;
                if (attr === selectedAttr) continue;

                var isValid = compatible.some(function (v) {
                    return v.attributes['attribute_' + attr] === value;
                });

                if (!isValid) {
                    opt.classList.add('disabled');
                    opt.setAttribute('aria-disabled', 'true');
                    opt.setAttribute('data-tooltip', 'این ترکیب موجود نیست');
                }
            }

            updateActiveStates();
        }

        function updateActiveStates() {
            var selected = {};
            var selects = form.querySelectorAll('select[name^="attribute_"]');
            selects.forEach(function (select) {
                var attr = select.name.replace('attribute_', '');
                if (select.value) {
                    selected[attr] = select.value;
                }
            });

            for (var i = 0; i < options.length; i++) {
                var opt = options[i];
                var attr = opt.dataset.attribute;
                var value = opt.dataset.value;
                var isActive = selected[attr] === value;

                if (isActive) {
                    opt.classList.add('active', '!ring-2', '!ring-sky-500');
                } else {
                    opt.classList.remove('active', '!ring-2', '!ring-sky-500');
                }
            }

            updateDisplayText();
        }

        function updateURL(attr, value) {
            try {
                var url = new URL(window.location.href);
                url.searchParams.set('attribute_' + attr, value);
                history.replaceState(null, '', url.toString());
            } catch (e) {
            }
        }

// ========== انتخاب خودکار ویژگی‌های غیررنگ با حفظ مقادیر قبلی ==========
        function autoSelectNonColorAttributes(selectedColor, selectedColorValue) {
            var compatible = validVariations.filter(function (v) {
                return v.attributes['attribute_' + selectedColor] === selectedColorValue;
            });

            if (compatible.length === 0) return;

            // مقادیر فعلی رو ذخیره کن
            var currentSelections = {};
            var selects = form.querySelectorAll('select[name^="attribute_"]');
            selects.forEach(function (select) {
                var attr = select.name.replace('attribute_', '');
                if (!isColorAttribute(attr) && select.value) {
                    currentSelections[attr] = select.value;
                }
            });

            var firstValid = compatible[0];

            selects.forEach(function (select) {
                var attr = select.name.replace('attribute_', '');

                if (isColorAttribute(attr)) return;

                // اگه مقدار فعلی با این رنگ سازگاره، حفظش کن
                if (currentSelections[attr]) {
                    var isCompatible = compatible.some(function (v) {
                        return v.attributes['attribute_' + attr] === currentSelections[attr];
                    });

                    if (isCompatible) {
                        return; // مقدار فعلی رو حفظ کن
                    }
                }

                // اگه سازگار نبود، از اولین واریاسیون معتبر استفاده کن
                var suggestedValue = firstValid.attributes['attribute_' + attr];
                if (suggestedValue && suggestedValue !== '') {
                    setSelect(attr, suggestedValue);
                }
            });
            //...
            updateActiveStates();


        }

        function applyFromURL() {
            try {
                var params = new URLSearchParams(window.location.search);
                var selected = {};

                params.forEach(function (val, key) {
                    if (key.startsWith('attribute_')) {
                        selected[key.replace('attribute_', '')] = val;
                    }
                });

                if (Object.keys(selected).length === 0) return false;

                var colorAttr = null;
                var colorValue = null;

                for (var attr in selected) {
                    if (isColorAttribute(attr)) {
                        colorAttr = attr;
                        colorValue = selected[attr];
                        break;
                    }
                }

                if (colorAttr && colorValue) {
                    setSelect(colorAttr, colorValue);
                }

                for (var attr in selected) {
                    if (!isColorAttribute(attr)) {
                        setSelect(attr, selected[attr]);
                    }
                }

                if (colorAttr && colorValue) {
                    filterOptions(colorAttr, colorValue);
                    autoSelectNonColorAttributes(colorAttr, colorValue);
                }

                updateActiveStates();
                return true;
            } catch (e) {
                return false;
            }
        }

        function autoPreselect() {
            if (validVariations.length === 0) return;

            var first = validVariations[0];
            var colorAttr = null;
            var colorValue = null;

            for (var key in first.attributes) {
                var attr = key.replace('attribute_', '');
                if (isColorAttribute(attr)) {
                    colorAttr = attr;
                    colorValue = first.attributes[key];
                    break;
                }
            }

            if (colorAttr && colorValue) {
                setSelect(colorAttr, colorValue);
                filterOptions(colorAttr, colorValue);
                autoSelectNonColorAttributes(colorAttr, colorValue);
            } else {
                var firstAttr = Object.keys(first.attributes)[0].replace('attribute_', '');
                var firstVal = first.attributes['attribute_' + firstAttr];
                setSelect(firstAttr, firstVal);
                filterOptions(firstAttr, firstVal);
            }
            updateActiveStates();
        }

        // ========== Event listener اصلی (با رفع باگ بازگشت به رنگ) ==========
        document.addEventListener('click', function (e) {
            var opt = e.target.closest('[data-attribute][data-value]');
            if (!opt || opt.classList.contains('disabled')) return;

            var attribute = opt.dataset.attribute;
            var value = opt.dataset.value;
            var isColor = isColorAttribute(attribute);

            var currentSelect = form.querySelector('select[name="attribute_' + attribute + '"]');

            // اگه همین گزینه قبلاً انتخاب شده بود
            if (currentSelect && currentSelect.value === value) {
                // updateActiveStates();
                return;
            }

            if (setSelect(attribute, value)) {
                if (isColor) {
                    filterOptions(attribute, value);
                    autoSelectNonColorAttributes(attribute, value);  // ✅ همیشه صدا زده میشه
                } else {
                    filterOptions(attribute, value);
                }
                // updateActiveStates();
                updateURL(attribute, value);
            }
            // autoSelectNonColorAttributes(attribute, value);
            updateActiveStates();
        });

        // ========== اجرای اولیه ==========
        disableInvalidColors();

        if (!applyFromURL()) {
            autoPreselect();
        }
    });
</script>
