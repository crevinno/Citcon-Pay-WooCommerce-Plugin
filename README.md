# Copyright (C) 2018 Crevinno
# This file is distributed under the same license as the pthnyc and crevinno Base Theme package.
#, fuzzy
Tags: wechatpay,wechat,alipay,creditcard pay,citconpay,paypal,api, payment gateway,CHOP,citcon hosted online payment, woocommerce, wordpress, POS api, Chainese consumers,PCI compliance, integrated architecture

Security : Highly encrypted. Contact for decrypt : support@crevinno.com

Requires at least: 4.5
Tested up to: 4.9.1
Stable tag: 1.1.2
License: GPLv3
License URI: https://www.gnu.org/licenses/gpl-3.0.html

API Reference
Citcon Integration APIs provide easy to use interfaces to fulfill all kinds of online payment needs. Citcon supports Alipay, WeChat Pay, UnionPay, and all kinds of Credit Card products. There are two types of integration provided: a simple yet flexible Citcon Hosted Online Payment (CHOP) method which helps merchants to get integrated fast and reduces PCI Compliance burden for merchants; and a classic backend API integration which provides the utmost granularity and flexibility but may require some development effort on merchant side.

== Description ==

A citcon hosted online payment wordpress plugin  that integrates with any WordPress WooCommerce theme.

The plugin allows you to easily manage ** WooCommerce Listings**, **Listing Enquiries** and ** Ecommerce products**, all from within your WordPress dashboard.

>Check Live Demo here [WP Citconpay DEMO](http://pthnyc.com)
>Citcon pay Doc api: (http://doc.citconpay.com/citconAPI/)



DONATION:

If this plugin really benefits you, give me a high praise, or recommend the plug-in to your friends

REMOVE PLUGIN

Deactivate plugin through the ‘Plugins’ menu in WordPress
Delete plugin through the ‘Plugins’ menu in WordPress

=== WP WooCommerce Citcon Payment ===
Contributors:pthnyc/mh
Creator's website link: http://crevinno.com

Installation
1) Open wp-admin in a browser, go to Plugins (/wp-admin/plugins.php)
2) Search Citcon pay WooCommerce plugin. Or Upload our woocommerce-citconpay.zip to Wordpress plugins directory. 
3) After successfully upload plugin. This will extract files into
/var/www/html/wp-content/plugins/citcon directory. There will 4 php files and 3 image files.
4) Activate Citcon Gateway for WooCommerce plugin
5) Go to WooCommerce->Settings, click on Checkout tab, scroll to bottom, click on
CitconPay to configure
7) Enter your API Token (aka CHOP Token) WeChat Pay, Credit card and Ali pay individually and select Test or Live environment accordingly.
Please note that token and environment must match. Save changes.


Key Features
•	Standard WooCommerce approved payment gateway.
•	Fully integrated into WooCommerce (with standard Woocommerce Payment Gateway Settings screen, adapted for Alipay,wechat pay and credit card using citconpay gateway).
•	Quick easy setup.  Just enter your Citocon pay TOKEN code into the settings screen.
•	Fully supports the Alipay,wechat pay and credit card test account.  The Merchant can use this to perform FREE test transactions (to check that the plugin, and their Alipay, Wechat pay,  credit card account, are both setup and working correctly).
•	Includes comprehensive documentation.  This documentation is translated into the 64 languages supported by Google Translate, which is important, since the Alipay payment screens are in Chinese only (with NO translations available).  The screens are also quite complicated since alipay,wechatpay not only takes security seriously, but also support a wide variety of Mainland China payment methods and cards.  Thus, navigating and using these screens (to make the test transactions for example) is next to impossible for those who don’t read Chinese.  But with our multi-language documentation and screenshots, it becomes quite straightforward.


Citcon Github: https://github.com/Citcon

Citcon Hosted Online Payment (CHOP) Demo in PHP

CHOP is Citcon's online payment product that helps online merchants quickly integrate a full payment solution.

Using hosted payment solutions by Citcon, merchants development cost is dramatically reduced because almost everything in the payment flow is built, hosted and managed by Citcon. This also significantly redeuced the liability and effort merchants otherwise have to be concerned with on security and data privacy. For example, merchants, who are taking credit card payments, normally need to be cerified by PCI-DSS; now, merchants only need to self-certify with PCI-DSS SAQ A-EP.

Better yet, merchants can customize the look and feel of the hosted forms via simple HTML and CSS.

Please read Citcon API documentation for details: http://doc.citconpay.com

This is a PHP demo and sample code for Citcon Hosted Online Payment APIs. Supports Alipay, WeChat Pay, Credit Cards. Feel free to use it and/or modify to suit your needs.

Contact info@citcon-inc.com if you have questions.
