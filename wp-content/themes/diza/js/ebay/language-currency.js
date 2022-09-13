/* 根据地区获取对应货币和语言 */
function areaSetLanguageCurrency(language, area)
{
    let areaLanguageCurrency = getAreaIso2(area);
    if (areaLanguageCurrency) {
        let languageCode = areaLanguageCurrency.language;
        let currencyCode = areaLanguageCurrency.currency;
        //假如language不存在，并且是一个数组
        if (Array.isArray(languageCode) && !language) {
            languageCode = languageCode[0];
        }
        if (language) {//根据地区未获取到对应语言
            languageCode = language;
        }
        if (languageCode) {//语言存在则存入
            setCookie("wp_lang", languageCode);//language
        }
        setCookie("currency", currencyCode);//currency
    }
}

/* 根据语言获取对应货币和语言 */
function setLanguageCurrency(language)
{
    const languages = {
        en: "USD",
        es: "MXN",
        fr: "EUR",
        it: "EUR",
        nl: "EUR",
        de: "EUR"
    }
    var currency = languages[language];
    if (currency) {
        jQuery.ajax({//如果获取不到用户浏览器中的数据就走接口获取将数据存入到cookie
            url: '/api/country',
            type: 'get',
            data: '',
            async: false,//改为同步请求，让其加载完成后在进行对应语言获取和渲染文本
            dataType: 'json',
            success: function (res) {
                var country = res.data.country
                if (country) {
                    let areaCurrency = getAreaIso2(country.iso_code)//根据地区获取到对应的币种
                    if (areaCurrency) {//如果币种存在则使用该币种，如果无则使用默认币种
                        currency = areaCurrency.currency
                    }
                    setCookie("wp_lang", language);//language
                    setCookie("currency", currency);//currency
                }
            }
        })
    }
}

function getAreaIso2(area)
{
    const areaISO2 = {
        HU:{currency:'HUF',language:''},
        JP:{currency:'JPY',language:''},
        NO:{currency:'NOK',language:''},
        PL:{currency:'PLN',language:''},
        RU:{currency:'RUB',language:''},
        SE:{currency:'SEK',language:''},
        AE:{currency:'AED',language:''},
        SA:{currency:'SAR',language:''},
        IL:{currency:'ILS',language:''},
        TH:{currency:'THB',language:''},
        TW:{currency:'TWD',language:''},
        MY:{currency:'MYR',language:''},
        KR:{currency:'KRW',language:''},
        EG:{currency:'EGP',language:''},
        IN:{currency:'INR',language:''},
        MA:{currency:'MAD',language:''},
        RO:{currency:'RON',language:''},
        TR:{currency:'TRY',language:''},
        UA:{currency:'UAH',language:''},
        VN:{currency:'VND',language:''},
        DK:{currency:'DKK',language:''},
        HK: {currency: 'HKD', language: 'en'},
        ID: {currency: 'IDR', language: 'en'},
        BR: {currency: 'BRL', language: 'es'},
        SG: {currency: 'SGD', language: 'en'},
        PK: {currency: 'PKR', language: 'en'},
        AR: {currency: 'ARS', language: 'es'},
        BO: {currency: 'EUR', language: 'es'},
        CL: {currency: 'CLP', language: 'es'},
        CO: {currency: 'COP', language: 'es'},
        CR: {currency: 'EUR', language: 'es'},
        DO : {
            currency: 'EUR', language: 'es'},
        EC: {currency: 'USD', language: 'es'},
        ES: {currency: 'EUR', language: 'es'},
        GT: {currency: 'EUR', language: 'es'},
        HN: {currency: 'EUR', language: 'es'},
        MX: {currency: 'MXN', language: 'es'},
        NI: {currency: 'EUR', language: 'es'},
        PA: {currency: 'EUR', language: 'es'},
        PE: {currency: 'PEN', language: 'es'},
        PR: {currency: 'USD', language: 'es'},
        PY: {currency: 'EUR', language: 'es'},
        SV: {currency: 'EUR', language: 'es'},
        VE: {currency: 'EUR', language: 'es'},
        UY: {currency: 'UYU', language: 'es'},
        AU: {currency: 'AUD', language: 'en'},
        BZ: {currency: 'USD', language: 'en'},
        CB: {currency: 'USD', language: 'en'},
        GB: {currency: 'GBP', language: 'en'},
        IE: {currency: 'EUR', language: 'en'},
        JM: {currency: 'USD', language: 'en'},
        NZ: {currency: 'NZD', language: 'en'},
        PH: {currency: 'PHP', language: 'en'},
        TT: {currency: 'USD', language: 'en'},
        US: {currency: 'USD', language: 'en'},
        ZW: {currency: 'USD', language: 'en'},
        ZA: {currency: 'ZAR', language: 'en'},
        AT: {currency: 'EUR', language: 'de'},
        DE: {currency: 'EUR', language: 'de'},
        LI: {currency: 'CHF', language: 'de'},
        FR: {currency: 'EUR', language: 'fr'},
        MC: {currency: 'EUR', language: 'fr'},
        IT: {currency: 'EUR', language: 'it'},
        NL: {currency: 'EUR', language: 'nl'},
        CA: {currency: 'CAD', language: ['en', 'fr']},
        LU: {currency: 'EUR', language: ['de', 'fr']},
        BE: {currency: 'EUR', language: ['fr', 'nl']},
        CH: {currency: 'CHF', language: ['de', 'fr', 'it']},
    }
    return areaISO2[area];
}
