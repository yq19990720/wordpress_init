jQuery(document).ready(function ($) {
    //获取user-agent进行规则匹配
    let userAgent = navigator.userAgent;//获取浏览器用户代理
    //正则匹配不区分大小写
    let reptile = new RegExp('googlebot|bingbot|yandexbot','i');
    if (!reptile.test(userAgent)) {//步骤一
        let language = getCookie("wp_lang");//获取缓存中的语言
        let currency = getCookie("currency");//获取缓存中的货币代码
        if (!language && !currency) {
            let userLanguage = navigator.language;//获取浏览器语言
            if (userLanguage) {//步骤二
                let country = userLanguage.split('-');//返回一个array，不存在“-”也会将该字符串转换为一个array数组
                switch (country.length) {
                    case 1:
                        setLanguageCurrency(country[0]);//根据获取到的语言存入语言和货币代码
                        break;
                    case 2:
                        areaSetLanguageCurrency(country[0],country[1]);
                        break;
                }
            } else {
                $.ajax({//如果获取不到用户浏览器中的数据就走接口获取将数据存入到cookie
                    url: '/api/country',
                    type: 'get',
                    data: '',
                    async: false,//改为同步请求，让其加载完成后在进行对应语言获取和渲染文本
                    dataType: 'json',
                    success: function (res) {
                        var country = res.data.country
                        if (country) {
                            areaSetLanguageCurrency('',country.iso_code);//根据接口给回的iso2地区存入数据
                        }
                    }
                })
            }
        }
    }

    $.ajax({
        url: '/?wc-ajax=ajax_is_user_logged_in',
        type: 'post',
        data: '',
        dataType: 'json',
        success: function (res) {
            //currency
            switchCurrency($,res)
            //switch language
            switchLanguage($)
            if (res.data['user'] === false) {
            //add to cart
                addToCart($)
            //remove mini cart
                removeMiniCart($)
            //remove view cart
                removeViewCart($)
                //login my-account
                var html1 = '<div class="tbay-login tbay-login-max"><a data-toggle="modal" data-target="#custom-login-wrapper" href="#custom-login-wrapper"><i aria-hidden="true" class="tb-icon tb-icon-account"></i></a></div>'
                $('.tbay-element-account').html(html1)

                var result  = get_seo_localstorage('product')
                var total = get_total(result);
                var price = get_price(result,res.data['rate']);
                var usd_price = get_price(result,1)
                var html2 = '<span class="cart-icon"><i class="tb-icon tb-icon-shopping-cart"></i><span class="mini-cart-items">' + total + '</span></span>' +
                    '<span class="text-cart"><span class="subtotal"><span class="woocommerce-Price-amount amount">' +
                    '<bdi><span class="woocommerce-Price-currencySymbol" usd_price="' + usd_price + '">' + res.data['language'][1] + price + '</span></bdi>' +
                    '</span></span></span>'
                $('.dropdown-max').html(html2)

                if (result) {
                    var html3 = '<dev class="mini_cart_content"><div class="mini_cart_inner"><div class="mcart-border"><ul class="cart_list product_list_widget ">'
                    $.each(result,function (i,item) {
                        html3 += '<li id="mcitem-' + item.cart_id + '"><div class="product-image"><a class="image"><img width="1" height="1" src="' + item.image + '" class="attachment-woocommerce_gallery_thumbnail size-woocommerce_gallery_thumbnail" alt></a></div>' +
                            '<div class="product-details"><a class="product-name" href="/detail/' + item.slug + '"><span>' + item.name + '</span></a><div class="group"><span class="quantity">' + item.quantity + ' x<span class="woocommerce-Price-amount amount"> <bdi><span class="woocommerce-Price-currencySymbol" usd_price="' + item.price + '">' + res.data['language'][1] + item.price * res.data['rate'] + '</bdi></span></span></div>' +
                            '<a href="javascript:void(0);" class="remove remove_from_cart_button" aria-label="Remove this item" data-product_id="' + item.cart_id + '"><i class="tb-icon tb-icon-trash"></i></a></div>' +
                            '</li>'
                    });
                    html3 += '</ul>' + '<div class="group-button"><p class="total"><strong class="diza-total">' + res.data['subtotal'] + ':</strong><span class="woocommerce-Price-amount amount">' +
                        '<bdi><span class="woocommerce-Price-currencySymbol" usd_price="' + usd_price + '">' + res.data['language'][1] + price + '</span></bdi>' +
                        '</span></p><p class="buttons"><a href="/cart" class="button view-cart">' + res.data['view_cart'] + '</a><a href="/checkout" class="button checkout mini-cart-checkout">' + res.data['checkout'] + '</a></p></div>' +
                        '</div></div></dev>'
                } else {
                    var html3 = '<dev class="mini_cart_content"><div class="mini_cart_inner"><div class="mcart-border"><ul class="cart_empty">' +
                        '<li><span>' + res.data['empty_cart'] + '</span></li><li class="total"><a class="button wc-continue" href="/shop">' + res.data['con_shop'] + '<i class="tb-icon tb-icon-chevron-right"></i></a></li>' +
                        '</ul><div class="clearfix"></div></div></div></dev>'
                }
                $('.widget_shopping_cart_content').html(html3)
            } else {
                //set cart
                products = get_seo_localstorage("product")
                product = [];
                quantity = [];
                if (products) {
                    $.each(products, function (i, items) {
                        product.push(items.cart_id)
                        quantity.push(items.quantity)
                    })
                    $.ajax({
                        url: '/?wc-ajax=get_seo_cart_add',
                        type: 'post',
                        data: {'add-to-cart': product, 'quantities': quantity},
                        dataType: 'json',
                        success: function (res) {
                            var subtotal = res.data.subtotal
                            var count = res.data.count
                            var min_subtotal = res.data.mini_subtotal
                            var usd_min_subtotal = res.data.usd_min_subtotal
                            var view_cart = res.data.view_cart
                            var checkout = res.data.checkout
                            delete res.data['subtotal']
                            delete res.data['count']
                            delete res.data['mini_subtotal']
                            delete res.data['usd_min_subtotal']
                            delete res.data['view_cart']
                            delete res.data['checkout']
                            var min_cart_html = '<span class="cart-icon"><i class="tb-icon tb-icon-shopping-cart"></i><span class="mini-cart-items">' + count + '</span></span>' +
                                '<span class="text-cart"><span class="subtotal"> <span class="woocommerce-Price-amount amount">' +
                                '<bdi><span class="woocommerce-Price-currencySymbol" usd_price="' + usd_min_subtotal + '">' + min_subtotal + '</span></bdi></span></span></span>'
                            $('.dropdown-max').html(min_cart_html)
                            var html = '<dev class="mini_cart_content"><div class="mini_cart_inner"><div class="mcart-border"><ul class="cart_list product_list_widget ">'
                            $.each(res.data, function (i, item) {
                                html += '<li id="mcitem-' + item.class_id + '"><div class="product-image"><a class="image">' + item.thumbnail + '</a></div>' +
                                    '<div class="product-details"><a class="product-name" href="' + item.product_permalink + '"><span>' + item.product_name + '</span></a><div class="group"><span class="quantity">' + item.product_num + 'x</span>' + item.product_price + '</div>' + item.product_remove + '</div>' +
                                    '</li>'
                            });
                            html += '</ul>' + '<div class="group-button"><p class="total">' + subtotal + '</p><p class="buttons"><a href="/cart" class="button view-cart">' + view_cart + '</a><a href="/checkout" class="button checkout">' + checkout + '</a></p></div>' +
                                '</div></div></dev>'
                            $('.widget_shopping_cart_content').html(html)
                        }
                    })
                    //delete localStorage data
                    localStorage.removeItem('product');
                    localStorage.removeItem('product_id');
                }
                //login my-account
                var html = ' <div class="tbay-login tbay-login-max"><a class="account-button" href="/my-account"><i aria-hidden="true" class="tb-icon tb-icon-account"></i></a>' +
                    '<div class="account-menu sub-menu">' +
                    '<div class="menu-my-account-container">' +
                    '<ul id="menu-1-3c6d0a8" class="menu">' +
                    '<li class="menu-item menu-item-type-post_type menu-item-object-page current-page-ancestor menu-item-1389">' +
                    '<a href="/my-account">' + res.data['my_amount'] + '</a>' +
                    '</li>' +
                    '<li class="menu-item menu-item-type-post_type menu-item-object-page current-page-ancestor menu-item-1390">' +
                    '<a href="/checkout">' + res.data['checkout'] + '</a>' +
                    '</li>' +
                    '<li class="menu-item menu-item-type-post_type menu-item-object-page current-page-ancestor menu-item-2089">' +
                    '<a href="/cart">' + res.data['cart'] + '</a>' +
                    '</li>' +
                    '</ul>' +
                    '</div>' +
                    '</div>' +
                    '</div>'
                $('.tbay-element-account').html(html)

                //login mini cart
                $.ajax({
                    url: '/?wc-ajax=get_cart',
                    type: 'post',
                    data: '',
                    dataType: 'json',
                    success: function (res) {
                        if (res.data.count <= 0) {
                            var empty_cart = '<dev class="mini_cart_content"><div class="mini_cart_inner"><div class="mcart-border"><ul class="cart_empty">' +
                                '<li><span>' + res.data['empty_cart'] + '</span></li><li class="total"><a class="button wc-continue" href="/shop">' + res.data['con_shop'] + '<i class="tb-icon tb-icon-chevron-right"></i></a></li>' +
                                '</ul><div class="clearfix"></div></div></div></dev>'
                            $('.widget_shopping_cart_content').html(empty_cart)
                        } else {
                            var subtotal = res.data.subtotal
                            var count = res.data.count
                            var min_subtotal = res.data.mini_subtotal
                            var usd_min_subtotal = res.data.usd_min_subtotal
                            var view_cart = res.data.view_cart
                            var checkout = res.data.checkout
                            delete res.data['subtotal']
                            delete res.data['count']
                            delete res.data['mini_subtotal']
                            delete res.data['usd_min_subtotal']
                            delete res.data['view_cart']
                            delete res.data['checkout']
                            //pc
                            var min_cart_html = '<span class="cart-icon"><i class="tb-icon tb-icon-shopping-cart"></i><span class="mini-cart-items">' + count + '</span></span>' +
                                '<span class="text-cart"><span class="subtotal"> <span class="woocommerce-Price-amount amount">' +
                                '<bdi><span class="woocommerce-Price-currencySymbol" usd_price="' + usd_min_subtotal + '">' + min_subtotal + '</span></bdi></span></span></span>'
                            $('.dropdown-max').html(min_cart_html)
                            //mobile
                            var dropdown_min = '<i class="tb-icon tb-icon-shopping-cart"></i><span class="mini-cart-items">' + count + '</span><span>Cart</span>'
                            $('.dropdown-min').html(dropdown_min)
                            var html = '<dev class="mini_cart_content"><div class="mini_cart_inner"><div class="mcart-border"><ul class="cart_list product_list_widget ">'
                            $.each(res.data,function (i,item) {
                                html += '<li id="mcitem-' + item.class_id + '"><div class="product-image"><a class="image">' + item.thumbnail + '</a></div>' +
                                    '<div class="product-details"><a class="product-name" href="' + item.product_permalink + '"><span>' + item.product_name + '</span></a><div class="group"><span class="quantity">' + item.product_num + 'x</span>' + item.product_price + '</div>' + item.product_remove + '</div>' +
                                    '</li>'
                            });
                            html += '</ul>' + '<div class="group-button"><p class="total">' + subtotal + '</p><p class="buttons"><a href="/cart" class="button view-cart">' + view_cart + '</a><a href="/checkout" class="button checkout mini-cart-checkout">' + checkout + '</a></p></div>' +
                                '</div></div></dev>'
                            $('.widget_shopping_cart_content').html(html)
                        }
                    }
                });
            }
            //language
            localLanguage(res)
            //price
            localPrice($,res)
        }
    })

})

function switchLanguage($)
{
    $(document.body).on('click', '.language_code', function (e) {
        closeMenu($);//隐藏侧边栏
        var language_code = $(this).attr("language_code")
        setCookie("wp_lang",language_code)
        $.ajax({
            url: '/?wc-ajax=ajax_is_user_logged_in',
            type: 'post',
            data: '',
            dataType: 'json',
            success: function (res) {
                localLanguage(res);
                localPrice($,res)
            }
        })
    })
}

function removeViewCart($)
{
    $(document.body).on('click', '.woocommerce-cart-form :input[type=submit]', function (evt) {
        var formData = $("#product_table").serializeArray()
        var date = new Date().getTime();
        products = get_seo_localstorage('product')
        products_ids = get_seo_localstorage('product_id')
        if (JSON.stringify(formData) !== '{}') {
            $.each(formData, function (i, item) {
                if (item.value != "") {
                    var number = Number(item.value);
                    if (!isNaN(number)) {//verify if string is a number
                        //Determine whether it is a decimal
                        var value = String(item.value).indexOf(".") + 1;//Get the position of the decimal point
                        if ( value > 0) {
                            return;
                        }
                        //cast to int
                        item.value = parseInt(item.value);
                        //equal 0 or null delete product
                        if (item.value == 0) {
                            delete products[item.name]
                            delete products_ids[item.name]
                        } else {
                            // Convert it to positive if it is negative
                            if (item.value < 0) {
                                item.value = item.value * -1
                            }
                            products[item.name]['quantity'] = item.value
                        }
                    }
                } else {
                    return;
                }
            })
            if (JSON.stringify(products) === '{}' || JSON.stringify(products_ids) === '{}') {
                localStorage.removeItem('product');
                localStorage.removeItem('product_id');
            } else {
                set_seo_localstorage('product', products, date + 60 * 60 * 24 * 1000)
                set_seo_localstorage('product_id', products_ids, date + 60 * 60 * 24 * 1000)
            }
        }
    })
}

function removeMiniCart($)
{
    $(document.body).on('click', '.remove_from_cart_button', function (e) {
        var product_id = $(this).attr("data-product_id")
        var date = new Date().getTime();
        products = get_seo_localstorage('product')
        products_ids = get_seo_localstorage('product_id')
        delete products_ids[product_id]
        delete products[product_id]
        if (JSON.stringify(products) === '{}' || JSON.stringify(products_ids) === '{}') {
            localStorage.removeItem('product');
            localStorage.removeItem('product_id');
        } else {
            set_seo_localstorage('product', products, date + 60 * 60 * 24 * 1000)
            set_seo_localstorage('product_id', products_ids, date + 60 * 60 * 24 * 1000)
        }
    });
}

function addToCart($)
{
    $(document.body).on('click', '.add_to_cart_max', function (e) {
        var $thisbutton = $(this),
            $form = $thisbutton.closest('form.cart'),
            quantity = $form.find('input[name=quantity]').val() || 1;
        if (quantity < 0) {
            quantity = quantity * -1
        }
        if (quantity == 0) {
            quantity = 1
        }
        var post_title = $(this).attr("data-title")
        var product_id = $(this).attr("value")
        var image_id = $(this).attr("data-image")
        var slug = $(this).attr("data-slug")
        var price = $(this).attr("data-price")
        var is_detail_ajax = $(this).attr("data-ajax")
        if (is_detail_ajax === "true") {
            product_id = $(this).attr("data-product_id")
        }
        var now_price = decimal(price);
        var date = new Date().getTime();
        //cast to int
        quantity = parseInt(quantity);
        product_arr = {};
        product_arr[product_id] = {
            'slug': slug,
            'cart_id': product_id,
            'name': post_title,
            'quantity': quantity,
            'product_id': product_id,
            'price': now_price,
            'image': image_id
        }
        product_arr_id = {};
        product_arr_id[product_id] = {product_id}
        products = get_seo_localstorage('product')
        products_id = get_seo_localstorage('product_id')
        if (products != null && products != '') {
            $.each(products, function (i, item) {
                if (item.product_id == product_id) {
                    item.quantity = math.add(item.quantity, quantity)
                }
            })
        }
        if (products_id) {
            //product未存储的商品数据
            if (products_id[product_id] == null) {
                products[product_id] = product_arr[product_id]
                products_id[product_id] = product_arr_id[product_id]
            }
            set_seo_localstorage('product', products, date + 60 * 60 * 24 * 1000)
            set_seo_localstorage('product_id', products_id, date + 60 * 60 * 24 * 1000)
        } else {
            set_seo_localstorage('product', product_arr, date + 60 * 60 * 24 * 1000)
            set_seo_localstorage('product_id', product_arr_id, date + 60 * 60 * 24 * 1000)
        }
    });
}

function switchCurrency($,res)
{
    $(document.body).on('click', '.currency_code', function (e) {
        closeMenu($);//隐藏侧边栏
        var currency_code = $(this).attr("currency_code")
        document.cookie = "currency=" + currency_code + ";" + "path=/";
        $('.currency_text').html("Currency & " + currency_code)
        $('.mm-navbar__title').html(currency_code + " " + res.data['currency_code_all'][currency_code]['code'])
        $(".woocommerce-Price-amount").find('.woocommerce-Price-currencySymbol').each(function () {
            var usd_price = $(this).attr("usd_price")
            var new_price = usd_price * res.data['rates'][currency_code]
            if (currency_code === "USD") {
                new_price = usd_price;
            }
            $price = res.data['currency_code_all'][currency_code]['code'] + decimal(Math.floor(new_price * 100) / 100);
            $(this)[0].innerHTML =  standard_price(res.data['language'][0],$price,res.data['currency_code_all'][currency_code]['code'],currency_code)
        });
    })
    $('.add_to_cart_max').removeAttr("disabled");
}


function closeMenu($)
{
    if (/Mobi|Android|iPhone/i.test(navigator.userAgent)) {//校验是否是手机端
        let api = $("#tbay-mobile-menu-navbar").data("mmenu");
        var arr = document.getElementsByClassName("mm-wrapper_opening");
        arr[0].classList.remove("mm-wrapper_opening");
        $('#tbay-mobile-menu-navbar').removeClass('mm-menu_opened');
        api.close();
    }
}

function localLanguage(res)
{
    //language
    var language_img_src = '<img src=' + res.data['language_img_src'] + '>' + res.data['Language'] + '<b class="caret"></b>'
    $('.language_text').html(language_img_src);
    var currency = 'Currency & ' + res.data['currency_code'] + '</span>' + '<b class="caret"></b>'
    $('.currency_text').html(currency);
    var purchases = '<div style="text-align: center;">' + res.data['purchases'] + '</div>'
    $('.purchases').html(purchases);
    var welcome = '<div style="text-align: center;">' + res.data['welcome'] + '</div>'
    $('.welcome').html(welcome);
    var street = '<div style="vertical-align: inherit;">' + res.data['address'] + ': ' + res.data['street'] + '</div>'
    $('.street').html(street);
    var callus = '<p>' + res.data['call_us'] + ': <span style="text-align: left; background-color: #ffffff;">' + res.data['phone_number'] + '</span></p>'
    $('.callus').html(callus);
    var menu_account_cart = '<li id="menu-item-1389" class="menu-item menu-item-type-post_type menu-item-object-page current-page-ancestor menu-item-1389"><a href="/my-account">' + res.data['my_amount'] + '</a></li>' +
        '        <li id="menu-item-1390" class="menu-item menu-item-type-post_type menu-item-object-page current-page-ancestor menu-item-1390"><a href="/cart">' + res.data['cart'] + '</a></li>'
    $('#menu-my-account').html(menu_account_cart)
    var support = '<li id="menu-item-1607" class="menu-item menu-item-type-post_type menu-item-object-page current-page-ancestor current-menu-item page_item page-item-584 current_page_item menu-item-1607 active  active "><a href="/contact-us">' + res.data['contact_us'] + '</a></li>' +
        '        <li id="menu-item-2106" class="menu-item menu-item-type-custom menu-item-object-custom current-menu-item menu-item-2106 active  active "><a href="/privacy-policy">' + res.data['privacy_policy'] + '</a></li>'
    $('#menu-support').html(support)
    var business_hours = '<p>' + res.data['business_hours'][0] + ': 8AM – 10PM</p><p>' + res.data['business_hours'][1] + ': 9AM-8PM</p><p>' + res.data['business_hours'][2] + ': Closed</p><p>' + res.data['business_hours'][3] + '</p>'
    $('.business-hours').html(business_hours)
    var copyright = '<span>' + res.data['copyright'][0] + '<a style="color: #007bff" href="/">&nbsp' + res.data['smtp_name'] + '</a>&nbsp' + res.data['copyright'][1] + '</span>'
    $('.copyright').html(copyright)
    var supper = '<span>' + res.data['email'] + ': ' + res.data['support'] + res.data['smtp_name'] + '</span>'
    $('.supper').html(supper)
    var heading_title = '<span class="title">' + res.data['heading'][0] + '</span>'
    $('.FeaturedProducts').html(heading_title)
    var heading_title1 = '<span class="title">' + res.data['heading'][1] + '</span>'
    $('.BestSellers').html(heading_title1)
    var heading_subtitle = '<span class="subtitle">' + res.data['heading'][2] + '</span>'
    $('.Visitourshoptoseeamazingproducts').html(heading_subtitle)
    var add_to_cart = '<span class="title-cart">' + res.data['add_to_cart'] + '</span>'
    $('.diza-cart').html(add_to_cart)
    $('#tbay-click-addtocart').html(add_to_cart)
    var categories = '<span>' + res.data['categories'] + '</span>'
    $('.diza-Categories-title').html(categories)
    var product = '<span>' + res.data['product'] + '</span>'
    $('.diza-product-title').html(product)
    var shop = '<span>' + res.data['shop'] + '</span>'
    $('.diza-shop-title').html(shop)
    $('.diza-Shop').html(shop)
    var home = '<span>' + res.data['home'] + '</span>'
    $('.diza-Home').html(home)
    var amount = '<span>' + res.data['my_amount'] + '</span>'
    $('.diza-Account').html(amount)
    var description = '<span>' + res.data['description'] + '</span>'
    $('.tab-description').html(description)
    var tbay_title = '<span>' + res.data['tbay_title'] + '</span>'
    $('.diza-tbay-title').html(tbay_title)
    var test = res.data['stock']
    $('.diza-stock').html(test)
    //login
    var login = res.data['login']
    $('.diza-login').html(login)
    var register = res.data['register']
    $('.diza-register').html(register)
    var remember_me = res.data['remember_me']
    $('.diza-remember-me').html(remember_me)
    var lost_pwd =  res.data['lost_pwd']
    $('.diza-lost-pwd').html(lost_pwd)
    var login_text = res.data['login_text']
    $('.diza-login-text').html(login_text)
    var register_text =  res.data['register_text']
    $('.register-text').html(register_text)
    $("#cus-username").attr('placeholder', res.data['username'])
    $("#cus-password").attr('placeholder', res.data['password'])
    $("#signonname").attr('placeholder', res.data['username'])
    $("#signonemail").attr('placeholder', res.data['email'])
    $("#signonpassword").attr('placeholder', res.data['password'])
    $("#password2").attr('placeholder', res.data['confirm_pwd'])
    $("#diza-submit-register").attr('value', res.data['register'])
    $("#diza-submit-login").attr('value', res.data['login'])


    //mini cart
    var miniCartSubTotal = res.data['subtotal']
    $('.diza-total').html(miniCartSubTotal)
    var miniCart = res.data['view_cart']
    $('.view-cart').html(miniCart)
    $('.wc-forward').html(miniCart)
    var miniCartCheckout  = res.data['checkout']
    $('.mini-cart-checkout').html(miniCartCheckout)

    /*//PrivacyPolicy
    var privacyPolicyTitle = res.data['privacy_policy']
    $('.entry-title-PrivacyPolicy').html(privacyPolicyTitle)
    var privacyPolicyContent = res.data['privacy_policy_content']
    $('.privacy_policy_content').html(privacyPolicyContent)*/

    //view Cart
    /*var viewCart = res.data['cart']
    $('.entry-title-Cart').html(viewCart)
    var viewCartProduct = res.data['product']
    $('.diza-cart-product').html(viewCartProduct)
    var viewCartPrice = res.data['price']
    $('.diza-cart-price').html(viewCartPrice)
    var viewCartQuantity = res.data['quantity']
    $('.diza-cart-quantity').html(viewCartQuantity)
    var viewCartTotal = res.data['total']
    $('.diza-cart-total').html(viewCartTotal)
    var viewCartContinueShopping = res.data['con_shop']
    $('.diza-cart-continue-shopping').html(viewCartContinueShopping)
    var viewCartEmptyCheckout = res.data['cart_empty_checkout']
    $('.diza-cart-empty-checkout').html(viewCartEmptyCheckout)
    var viewCartEmpty = res.data['empty_cart']
    $('.diza-cart-empty').html(viewCartEmpty)
    var viewCartShop = res.data['cart_shop']
    $('.diza-cart-shop').html(viewCartShop)
    var viewCartTotals = res.data['cart_totals']
    $('.diza-cart-totals').html(viewCartTotals)
    var viewCartFreight = res.data['freight']
    $('.diza-freight').html(viewCartFreight)
    var viewCartProceedCheckout = res.data['proceed_checkout']
    $('.diza-checkout').html(viewCartProceedCheckout)
    var viewCartUpdate = document.getElementById("diza-update")
    if(viewCartUpdate){
        viewCartUpdate.setAttribute("value",res.data['update_cart']);
    }*/

}

function localPrice($,res)
{
    $(".woocommerce-Price-amount").find('.woocommerce-Price-currencySymbol').each(function () {
        var price = res.data['language'][1] + $(this).attr("usd_price") * res.data['rate']
        $(this)[0].innerHTML = standard_price(res.data['language'][0], price, res.data['language'][1], res.data['currency_code'])
    });
}

function set_seo_localstorage(key, value, ttl_ms)
{
    var data = { value: value, expirse: new Date(ttl_ms).getTime() };
    localStorage.setItem(key, JSON.stringify(data));
}

function get_seo_localstorage(key)
{
    var data = JSON.parse(localStorage.getItem(key));
    if (data !== null) {
        //debugger
        if (data.expirse != null && data.expirse < new Date().getTime()) {
            localStorage.removeItem(key);
        } else {
            return data.value;
        }
    }
    return null;
}

function get_total(value)
{
    var total = 0;
    $.each(value, function (i, item) {
        total = math.add(total,item.quantity);
    })
    return total;
}

function get_price(value,rate)
{
    var price = 0;
    if (value) {
        $.each(value, function (i, item) {
            price += item.price * item.quantity;
        })
        price = rate ? Math.floor(price * 100) / 100 * rate : Math.floor(price * 100) / 100
        return decimal(price);
    }
    return 0;
}

function get_price_total(value)
{
    var price = 0;
    if (value) {
        $.each(value, function (i, item) {
            price += item.price * item.quantity;
        })
        price =  Math.floor(price * 100) / 100
        return '<span class="woocommerce-Price-amount amount">' +
            '<bdi><span class="woocommerce-Price-currencySymbol">$' + decimal(price) + '</span></bdi>' +
            '</span>'
    }
    return '<span class="woocommerce-Price-amount amount">' +
        '<bdi><span class="woocommerce-Price-currencySymbol">$0.00</span></bdi>' +
        '</span>';
}

function decimal(num)
{
    num = Math.floor(num * 100) / 100
    if (typeof(num) == 'number') { // 判断是否为数字类型   数字类型自动  舍0
        num = num.toString() // 先转成  字符串类型
        if (num.indexOf(".") != -1) { // 判断 有无小数点  0 表示 有小数点  -1  表示没有小数点
            let b = num.split('.') // 根据小数点  转换字符串为数组
            if (b[1].length == 1) { // 判断 有几位小数  如果有一位  加一个0
                b = b.join('.')
                b += '0'
                num = b
            }
        } else {
            num += '.00'
        }
    } else if (typeof(num) == 'string') { // 同理
        if (num.indexOf(".") != -1) {
            let b = num.split('.')
            if (b[1].length == 1) {
                b = b.join('.')
                b += '0'
                num = b
            }
        } else {
            num += '.00'
        }
    }
    return num;
}
function standard_price(language,price,currency_symbol,currency_code)
{
    if (!language) {
        language =  getCookie('wp_lang')
    }
    price = price.replace(currency_symbol,'',)
    price = price.replace(',','',)
    price = price.replace('&nbsp;','',)
    price = Number(price)
    switch (language) {
        case 'en_US':
            price = price.toLocaleString('en-US', { style: 'currency', currency: currency_code })
            price = standard_currency_symbol(price)
            break;
        case 'fr_FR':
            price = price.toLocaleString('fr-FR', { style: 'currency', currency: currency_code })
            price = standard_currency_symbol(price)
            break;
        case 'de_DE':
        case 'it_IT':
        case 'es_ES':
            price = price.toLocaleString('de-DE', { style: 'currency', currency: currency_code })
            price = standard_currency_symbol(price)
            break;
        case 'nl_NL_formal':
            price = price.toLocaleString('nl-NL', { style: 'currency', currency: currency_code })
            price = standard_currency_symbol(price)
            break;
        default:
            return false;
    }
    price = price.replace(/US/,'')
    return price
}

function standard_currency_symbol(price)
{
    var symbol_map = {"CAD":"$","CA$":"$","$CA":"$","C$":"$","AUD":"$","AU$":"$","$AU":"$","A$":"$","CZK":"Kč","DKK":"kr","GBP":"£","£GB":"£","HKD":"HK$","HUF":"Ft","JPY":"¥","JP¥":"¥","NOK":"kr","NZD":"$","NZ$":"$","$NZ":"$","PLN":"zł","RUB":"₽","SEK":"kr","USD":"$","US$":"$","$US":"$","SGD":"$","$SG":"$","AED":"د.إ","SAR":"ريال","MXN":"$","MX$":"$","$MX":"$","COP":"$","$CO":"$","ARS":"$","$AR":"$","PEN":"S/","CLP":"$","$CL":"$","ILS":"₪","PHP":"₱","THB":"฿","TWD":"NT$","MYR":"RM","BRL":"R$","KRW":"₩","EGP":"£","IDR":"₹","MAD":"د.م.","PKR":"₨","RON":"lei","TRY":"₺","UAH":"₴","UYU":"$U","$UY":"$U","VND":"₫","ZAR":"R","CHF":"CHF"}
    for (let i in symbol_map) {
        if (price.indexOf(i) !== -1) {
            price = price.replace(i,symbol_map[i])
        }
    }
    return price
}

function getCookie(cname)
{
    var name = cname + "=";
    var ca = document.cookie.split(';');
    for (var i = 0; i < ca.length; i++) {
        var c = ca[i].trim();
        if (c.indexOf(name) == 0) {
            return c.substring(name.length,c.length);
        }
    }
    return "";
}

function setCookie(cname,cvalue)
{
    document.cookie = cname + "=" + cvalue + ";" + "path=/";
}
