<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

do_action( 'woocommerce_before_checkout_form', $checkout );

// If checkout registration is disabled and not logged in, the user cannot checkout.
if ( ! $checkout->is_registration_enabled() && $checkout->is_registration_required() && ! is_user_logged_in() ) {
    echo esc_html( apply_filters( 'woocommerce_checkout_must_be_logged_in_message', __( 'You must be logged in to checkout.', 'woocommerce' ) ) );
    return;
}


?>
<link rel='stylesheet' href='<?php echo plugins_url('../../../css/checkout.css', __FILE__) ?>' type='text/css' media='all' />
<style>
    :root {
        --color-accent: #002CB1;
        --color-button: #162FD9 ;
        --color-error: #D97706 ;
        --color-error-background: rgba(217,119,6, 0.2) ;
    }
    .hs-input{
        line-height: inherit !important;
    }

    .hs-button {
        height: unset;
    }
</style>
<div class="lg:flex">
    <div class="flex flex-row-reverse min-h-screen bg-white lg:w-7/12 lg:px-8 xl:px-12 2xl:px-16 3xl:px-56 4xl:px-96 lg:pt-2">
        <form class="w-full">
            <div class="stext-sm font-bold 2xl:text-baseticky top-0 z-10 flex items-center p-4 bg-white border-b border-gray-200 lg:z-auto lg:static lg:border-0">
                <a class="flex-grow" href="https://weeb.hu"><h1 class="text-2xl align-self-center">weeb</h1></a>
                <div class="flex items-center h-12 px-3 text-sm bg-gray-100 border border-gray-200 rounded cursor-pointer xl:h-16 space-x-5 lg:hidden">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-front-icons h-front-icons" viewBox="0 0 20 20" fill="currentColor"><path d="M3 1a1 1 0 000 2h1.22l.305 1.222a.997.997 0 00.01.042l1.358 5.43-.893.892C3.74 11.846 4.632 14 6.414 14H15a1 1 0 000-2H6.414l1-1H14a1 1 0 00.894-.553l3-6A1 1 0 0017 3H6.28l-.31-1.243A1 1 0 005 1H3zM16 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM6.5 18a1.5 1.5 0 100-3 1.5 1.5 0 000 3z"></path></svg>
                    <div class="py-1 ml-5 mr-1 text-right">
                        <div class="font-bold">1&nbsp;598&nbsp;000,00&nbsp;Ft</div>
                    </div>
                    <div class="text-gray-300">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-front-icons h-front-icons" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </div>
                </div>
            </div>
            <div class="mt-4"></div>
            <div class="container max-w-screen-xl mx-auto fixed inset-0 z-10 min-h-full overflow-y-auto lg:hidden bg-white divide-y divide-gray-200 hidden">
                <div class="sticky top-0 z-10 p-4 bg-white border-b border-gray-200 lg:z-auto lg:static">
                    <div class="flex items-center h-12 p-3 text-sm bg-gray-100 border border-gray-200 rounded cursor-pointer space-x-5 lg:hidden">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-front-icons h-front-icons" viewBox="0 0 20 20" fill="currentColor"><path d="M3 1a1 1 0 000 2h1.22l.305 1.222a.997.997 0 00.01.042l1.358 5.43-.893.892C3.74 11.846 4.632 14 6.414 14H15a1 1 0 000-2H6.414l1-1H14a1 1 0 00.894-.553l3-6A1 1 0 0017 3H6.28l-.31-1.243A1 1 0 005 1H3zM16 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM6.5 18a1.5 1.5 0 100-3 1.5 1.5 0 000 3z"></path></svg>
                        <div class="flex-grow font-bold">Cart Summary (1)</div>
                        <div class="py-1 mr-1 text-right">
                            <div class="font-bold">1&nbsp;598&nbsp;000,00&nbsp;Ft</div>
                        </div>
                        <div class="text-gray-300"><svg xmlns="http://www.w3.org/2000/svg" class="w-front-icons h-front-icons" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"></path></svg></div>
                    </div>
                </div>
                <ul class="divide-y divide-gray-200">
                    <li class="px-6 py-4 xl:px-0">
                        <div class="flex items-center space-x-4">
                            <div class="relative"><img class="inline-block object-cover w-16 h-16 border-2 border-gray-200 rounded" src="https://weeb.hu/wp-content/uploads/2021/05/Shippuden-Fifth-Hokage-Tsunade-Cosplay-Wig-Long-Straight-Blond-Hair-Peluca-Anime-Costume-Wigs.jpg" alt="Tsunade paróka">
                                <div class="absolute badge -top-2 -right-2">2</div>
                            </div>
                            <div class="flex-grow">
                                <h3 class="mb-1 text-sm font-bold 2xl:text-base">Tsunade paróka</h3>
                                <p class="text-sm antialiased text-gray-400 2xl:text-base">Tsunade paróka</p>
                            </div>
                            <div class="text-sm font-bold 2xl:text-base">15.980 Ft</div>
                        </div>
                    </li>
                </ul>
                <div class="p-6 text-sm lg:text-base 2xl:text-lg xl:px-0 grid grid-cols-2 align-items-center gap-y-3 2xl:gap-y-4">
                    <div class="antialiased">Subtotal</div>
                    <div class="justify-self-end">15.980 Ft</div>
                    <div class="antialiased">Foxpost - csomagautomatába</div>
                    <div class="justify-self-end">0,00&nbsp;Ft</div>
                </div>
                <div class="p-6 font-bold xl:px-0 grid grid-cols-2 align-items-center">
                    <div class="text-sm lg:text-base 2xl:text-lg">Total</div>
                    <div class="lg:text-lg 2xl:text-xl justify-self-end">15.980 Ft</div>
                </div>
                <div class="hidden lg:block"></div>
            </div>
            <div class="px-4 mt-6 space-y-10">
                <div>
                    <div class="col-span-2 lg:hidden">
                        <div class="pb-4 mb-4 border-b border-gray-200">
                            <div class="flex space-x-3">
                                <div class="relative flex-grow border-2 rounded bg-white text-field focus-within:border-brand-accent">
                                    <input type="text" name="discount_code" placeholder=" " class="block w-full pt-5 pb-1 pl-3 bg-transparent border-0 appearance-none focus:border-0 focus:outline-none hs-input" value="">
                                    <label for="discount_code" class="absolute top-0 p-3 pt-3 text-gray-400 pointer-events-none duration-300" style="transform-origin: 0% center;">Discount code</label>
                                </div>
                                <button type="button" class="w-24 btn-outline focus:outline-none focus:ring-2" disabled="">Apply</button>
                            </div>
                        </div>
                    </div>
                    <h2 class="flex items-center mb-4 text-lg font-bold xl:text-2xl 2xl:mb-6">Shipping Details</h2>
                    <div class="grid grid-cols-2 gap-3 xl:gap-4">
                        <div class="col-span-2">
                            <div class="border-gray text-field relative border-2 focus-within:border-brand-accent rounded">
                                <input type="text" name="email" id="email" placeholder=" " class="block w-full pt-5 pb-1 bg-transparent border-0 appearance-none focus:border-0 focus:outline-none" inputmode="email">
                                <label for="email" class="absolute top-0 p-3 pt-3 text-gray-400 pointer-events-none duration-300" style="transform-origin: 0% center;">Email Address</label>
                            </div>
                        </div>
                        <div>
                            <div class="border-gray text-field relative border-2 focus-within:border-brand-accent rounded">
                                <input type="text" name="shipping_first_name" id="shipping_first_name" placeholder=" " class="block w-full pt-5 pb-1 bg-transparent border-0 appearance-none focus:border-0 focus:outline-none">
                                <label for="shipping_first_name" class="absolute top-0 p-3 pt-3 text-gray-400 pointer-events-none duration-300" style="transform-origin: 0% center;">First Name</label>
                            </div>
                        </div>
                        <div>
                            <div class="border-gray text-field relative border-2 focus-within:border-brand-accent rounded">
                                <input type="text" name="shipping_last_name" id="shipping_last_name" placeholder=" " class="block w-full pt-5 pb-1 bg-transparent border-0 appearance-none focus:border-0 focus:outline-none">
                                <label for="shipping_last_name" class="absolute top-0 p-3 pt-3 text-gray-400 pointer-events-none duration-300" style="transform-origin: 0% center;">Last Name</label>
                            </div>
                        </div>
                        <div class="col-span-2">
                            <div class="border-gray text-field relative border-2 focus-within:border-brand-accent rounded">
                                <input type="text" name="shipping_address" id="shipping_address" placeholder=" " class="block w-full pt-5 pb-1 bg-transparent border-0 appearance-none focus:border-0 focus:outline-none">
                                <label for="shipping_address" class="absolute top-0 p-3 pt-3 text-gray-400 pointer-events-none duration-300" style="transform-origin: 0% center;">Address</label>
                            </div>
                        </div>
                        <div>
                            <div class="border-gray text-field relative border-2 focus-within:border-brand-accent rounded">
                                <input type="text" name="shipping_city" id="shipping_city" placeholder=" " class="block w-full pt-5 pb-1 bg-transparent border-0 appearance-none focus:border-0 focus:outline-none">
                                <label for="shipping_city" class="absolute top-0 p-3 pt-3 text-gray-400 pointer-events-none duration-300" style="transform-origin: 0% center;">City</label>
                            </div>
                        </div>
                        <div>
                            <div class="border-gray text-field relative border-2 focus-within:border-brand-accent rounded">
                                <input type="text" name="shipping_zip" id="shipping_zip" placeholder=" " class="block w-full pt-5 pb-1 bg-transparent border-0 appearance-none focus:border-0 focus:outline-none">
                                <label for="shipping_zip" class="absolute top-0 p-3 pt-3 text-gray-400 pointer-events-none duration-300" style="transform-origin: 0% center;">Zip Code</label>
                            </div>
                        </div>
                        <div class="flex col-span-2 space-x-3">
                            <div class="flex-1">
                                <select name="shipping_country_code" class="dropdown w-full border-gray-200">
                                    <option value="HU">Hungary</option>
                                </select>
                            </div>
                        </div>
                        <div class="flex col-span-2">
                            <label class="inline-flex items-start justify-start pl-1 my-1 cursor-pointer checkbox">
                                <div class="flex items-center justify-center flex-shrink-0 w-5 h-5 mr-2 bg-white border-2 rounded cursor-pointer focus-within:border-brand-accent focus-within:ring-2">
                                    <input name="accepts_marketing" type="checkbox" class="absolute opacity-0 cursor-pointer">
                                    <svg class="hidden w-4 h-4 text-white pointer-events-none fill-current bg-brand-accent" viewBox="-3 -2 25 25"><path d="M0 11l2-2 5 5L18 3l2 2L7 18z"></path></svg>
                                </div>
                                <div class="text-sm select-none">Sign up for exclusive offers and news</div>
                            </label>
                        </div>
                    </div>
                </div>
                <div>
                    <h2 class="flex items-center mb-4 text-lg font-bold xl:text-2xl 2xl:mb-6">Shipping Options
                        <div class="w-4 ml-2 mr-2 -mt-1 text-brand-accent">
                            <svg viewBox="0 0 26 26" version="1.1" xmlns="http://www.w3.org/2000/svg"><g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"><g transform="translate(-870.000000, -205.000000)" fill="currentColor" fill-rule="nonzero"><g transform="translate(423.000000, 158.000000)"><path d="M460,73 C463.583333,73 466.645833,71.7291667 469.1875,69.1875 C471.729167,66.6458333 473,63.5833333 473,60 L473,60 L470.375,60 C470.375,62.875 469.364583,65.3229167 467.34375,67.34375 C465.322917,69.3645833 462.875,70.375 460,70.375 C457.125,70.375 454.677083,69.3645833 452.65625,67.34375 C450.635417,65.3229167 449.625,62.875 449.625,60 C449.625,57.125 450.635417,54.6770833 452.65625,52.65625 C454.677083,50.6354167 457.125,49.625 460,49.625 C461,49.625 461.958333,49.75 462.875,50 L462.875,50 L464.875,48 C463.291667,47.3333333 461.666667,47 460,47 C456.416667,47 453.354167,48.2708333 450.8125,50.8125 C448.270833,53.3541667 447,56.4166667 447,60 C447,63.5833333 448.270833,66.6458333 450.8125,69.1875 C453.354167,71.7291667 456.416667,73 460,73 Z M458.6875,65.1875 L471.6875,52.1875 L469.875,50.375 L458.6875,61.5 L454.6875,57.5 L452.875,59.375 L458.6875,65.1875 Z"></path></g></g></g></svg>
                        </div>
                    </h2>
                    <div class="grid space-y-2 xl:space-y-4">
                        <label class="flex items-center p-3 border-2 rounded cursor-pointer shipping-rate justify-items-center radio">
                            <div class="inline-flex items-center rounded-full focus-within:ring-2">
                                <input name="shipping_rate_id" type="radio" class="sr-only" value="130066">
                                <span class="inline-block w-5 h-5 border-2 border-gray-300 rounded-full flex-no-shrink"></span>
                            </div>
                            <div class="flex-grow pl-3">Foxpost - csomagautomatába</div>
                            <div class="text-sm font-bold justify-self-end">Ingyenes</div>
                        </label>
                        <label class="flex items-center p-3 border-2 rounded cursor-pointer shipping-rate justify-items-center radio">
                            <div class="inline-flex items-center rounded-full focus-within:ring-2">
                                <input name="shipping_rate_id" type="radio" class="sr-only" value="130064">
                                <span class="inline-block w-5 h-5 border-2 border-gray-300 rounded-full flex-no-shrink"></span>
                            </div>
                            <div class="flex-grow pl-3">Ingyenes szállítás</div>
                            <div class="text-sm font-bold justify-self-end">Ingyenes</div>
                        </label>
                        <label class="flex items-center p-3 border-2 rounded cursor-pointer shipping-rate justify-items-center radio">
                            <div class="inline-flex items-center rounded-full focus-within:ring-2">
                                <input name="shipping_rate_id" type="radio" class="sr-only" value="130065">
                                <span class="inline-block w-5 h-5 border-2 border-gray-300 rounded-full flex-no-shrink"></span>
                            </div>
                            <div class="flex-grow pl-3">Házhozszállítás</div>
                            <div class="text-sm justify-self-end">1.490 Ft</div>
                        </label>
                    </div>
                </div>
                <div>
                    <div class="items-center pl-1 mb-4 lg:flex 2xl:mb-6">
                        <h2 class="items-center flex-grow text-lg font-bold xl:text-2xl">Payment Method</h2>
                        <div class="flex items-center pt-2 text-sm antialiased text-gray-400 space-x-1 lg:pt-0">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-front-icons h-front-icons" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd"></path></svg>
                            <span>A tranzakció SSL-en keresztül biztosított</span>
                        </div>
                    </div>
                    <div class="grid space-y-2 xl:space-y-4">
                        <div class="border-2 rounded">
                            <label class="flex items-center p-3 cursor-pointer justify-items-center radio">
                                <div class="inline-flex items-center rounded-full focus-within:ring-2">
                                    <input name="gateway_id" type="radio" class="sr-only" value="d89fb755-feea-4150-9015-d3bf99891f13">
                                    <span class="inline-block w-5 h-5 border-2 border-gray-300 rounded-full flex-no-shrink"></span>
                                </div>
                                <div class="flex-grow pl-3">Cash on Delivery</div>
                                <div class="flex items-center space-x-2 justify-self-end">
                                    <img src="https://d2dehg7zmi3qpg.cloudfront.net/packs/media/images/payment_logos/cash_on_delivery-888e0b04f9b94511354d451743be0038.svg" alt="Cash on Delivery" class="w-auto h-5 md:h-6">
                                </div>
                            </label>
                        </div>
                    </div>
                </div>
                <label class="inline-flex items-start justify-start pl-1 my-1 cursor-pointer checkbox">
                    <div class="flex items-center justify-center flex-shrink-0 w-5 h-5 mr-2 bg-white border-2 rounded cursor-pointer focus-within:border-brand-accent focus-within:ring-2 border-brand-accent">
                        <input name="billing_address_same_as_shipping" type="checkbox" class="absolute opacity-0 cursor-pointer">
                        <svg class="hidden w-4 h-4 text-white pointer-events-none fill-current bg-brand-accent" viewBox="-3 -2 25 25"><path d="M0 11l2-2 5 5L18 3l2 2L7 18z"></path></svg>
                    </div>
                    <div class="text-sm select-none">Billing address is the same as shipping</div>
                </label>
                <div class="pb-4 lg:px-0 lg:pt-0 lg:border-0 lg:relative">
                    <button type="submit" class="w-full btn-primary focus:outline-none focus:ring-2 hs-button" disabled="">
                        <div class="flex items-center">
                            <div class="mr-2 -mt-1">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-front-icons h-front-icons" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd"></path></svg>
                            </div>Pay 1&nbsp;598&nbsp;000,00&nbsp;Ft
                        </div>
                    </button>
                </div>
                <div class="hidden lg:block"></div>
            </div>
        </form>
    </div>
    <div class="hidden w-5/12 pt-6 border-l border-gray-200 xl:pt-10 xl:px-12 3xl:px-32 bg-xgray-50 lg:block divide-y divide-gray-200">
        <div class="w-full divide-y divide-gray-200 3xl:w-8/12">
            <ul class="divide-y divide-gray-200">
                <li class="px-6 py-4 xl:px-0">
                    <div class="flex items-center space-x-4">
                        <div class="relative">
                            <img class="inline-block object-cover w-16 h-16 border-2 border-gray-200 rounded" src="https://weeb.hu/wp-content/uploads/2021/05/Shippuden-Fifth-Hokage-Tsunade-Cosplay-Wig-Long-Straight-Blond-Hair-Peluca-Anime-Costume-Wigs.jpg" alt="Tsunade paróka">
                            <div class="absolute badge -top-2 -right-2">2</div>
                        </div>
                        <div class="flex-grow">
                            <h3 class="mb-1 text-sm font-bold 2xl:text-base">Tsunade paróka</h3>
                            <p class="text-sm antialiased text-gray-400 2xl:text-base">Tsunade paróka</p>
                        </div>
                        <div class="text-sm font-bold 2xl:text-base">15.980 Ft</div>
                    </div>
                </li>
            </ul>
            <div class="px-5 py-6 xl:px-0">
                <div class="flex space-x-3">
                    <div class="relative flex-grow border-2 rounded bg-white text-field focus-within:border-brand-accent">
                        <input type="text" name="discount_code" placeholder=" " class="block w-full pt-5 pb-1 pl-3 bg-transparent border-0 appearance-none focus:border-0 focus:outline-none" value="">
                        <label for="discount_code" class="absolute top-0 p-3 pt-3 text-gray-400 pointer-events-none duration-300" style="transform-origin: 0% center;">Discount code</label>
                    </div>
                    <button type="button" class="w-24 btn-outline focus:outline-none focus:ring-2" disabled="">Apply</button>
                </div>
            </div>
            <div class="p-6 text-sm lg:text-base 2xl:text-lg xl:px-0 grid grid-cols-2 align-items-center gap-y-3 2xl:gap-y-4">
                <div class="antialiased">Subtotal</div>
                <div class="justify-self-end">15.980 Ft</div>
                <div class="antialiased">Foxpost - csomagautomatába</div>
                <div class="justify-self-end">0 Ft</div>
            </div>
            <div class="p-6 font-bold xl:px-0 grid grid-cols-2 align-items-center">
                <div class="text-sm lg:text-base 2xl:text-lg">Total</div>
                <div class="lg:text-lg 2xl:text-xl justify-self-end">15.980 Ft</div>
            </div>
            <div class="flex justify-center lg:py-6">
            </div>
        </div>
    </div>
</div>