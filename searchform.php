<div class="flex-1 w-xl max-xl:w-md max-md:w-auto max-lg:grow">
    <form
            method="get"
            action="<?php echo esc_url( home_url('/') ); ?>"
            id="form-search-ecommerce"
            class="relative flex-sbc flex-row"
    >

        <label class="flex grow">
            <input
                    type="search"
                    id="live-search-input"
                    name="s"
                    placeholder=" جستجو در فروشگاه "
                    class="w-full flex pl-20 py-3 bg-base-200 rounded-box border-none pr-14"
                    value="<?php echo get_search_query(); ?>"
            />
        </label>

        <div class="flex-cc text-base-300">
            <i class="absolute left-4 fa-solid fa-grip-dots-vertical"></i>
        </div>

        <button type="submit" class="flex-cc">
            <span class="absolute right-4">
                <i class="fa-solid fa-magnifying-glass fa-xl text-neutral-500"></i>
            </span>
        </button>

    </form>
</div>
