<?php
/**
 * Title: Product Section
 * Slug: automotive-car-dealer/product-section
 * Categories: template
 */

$automotive_car_dealer_pluginsList = get_option( 'active_plugins' );
$automotive_car_dealer_plugin = 'woocommerce/woocommerce.php';
$automotive_car_dealer_results = in_array( $automotive_car_dealer_plugin , $automotive_car_dealer_pluginsList);
if ( $automotive_car_dealer_results )  {
?>

<!-- wp:group {"tagName":"main","className":"product-sec","style":{"spacing":{"padding":{"top":"5em","bottom":"5em","left":"0","right":"0"},"margin":{"top":"0","bottom":"0"}}},"backgroundColor":"body-color","layout":{"type":"constrained","contentSize":"80%"}} -->
<main class="wp-block-group product-sec has-body-color-background-color has-background" style="margin-top:0;margin-bottom:0;padding-top:5em;padding-right:0;padding-bottom:5em;padding-left:0"><!-- wp:group {"className":"product-top-title-grp","layout":{"type":"constrained"}} -->
<div class="wp-block-group product-top-title-grp"><!-- wp:paragraph {"className":"product-top-tite","style":{"typography":{"textAlign":"center","fontSize":"17px","fontStyle":"normal","fontWeight":"400"},"elements":{"link":{"color":{"text":"var:preset|color|primary"}}}},"textColor":"primary","fontFamily":"poppins"} -->
<p class="has-text-align-center product-top-tite has-primary-color has-text-color has-link-color has-poppins-font-family" style="font-size:17px;font-style:normal;font-weight:400"><?php esc_html_e('CAR PARTS','automotive-car-dealer'); ?></p>
<!-- /wp:paragraph --></div>
<!-- /wp:group -->

<!-- wp:heading {"style":{"elements":{"link":{"color":{"text":"var:preset|color|secondary"}}},"typography":{"textAlign":"center","fontSize":"33px","fontStyle":"normal","fontWeight":"700"},"spacing":{"padding":{"top":"0","bottom":"0","left":"0","right":"0"},"margin":{"top":"0","bottom":"0","left":"0","right":"0"}}},"textColor":"secondary","fontFamily":"Outfit"} -->
<h2 class="wp-block-heading has-text-align-center has-secondary-color has-text-color has-link-color has-outfit-font-family" style="margin-top:0;margin-right:0;margin-bottom:0;margin-left:0;padding-top:0;padding-right:0;padding-bottom:0;padding-left:0;font-size:33px;font-style:normal;font-weight:700"><?php esc_html_e('Power in Every Part','automotive-car-dealer'); ?></h2>
<!-- /wp:heading -->

<!-- wp:paragraph {"className":"product-para","style":{"typography":{"textAlign":"center","fontSize":"15px","fontStyle":"Thin","fontWeight":"300"},"color":{"text":"#676767"},"elements":{"link":{"color":{"text":"#676767"}}},"spacing":{"padding":{"top":"0","bottom":"0","left":"0","right":"0"},"margin":{"top":"0","bottom":"0","left":"0","right":"0"}}},"fontFamily":"Poppins"} -->
<p class="has-text-align-center product-para has-text-color has-link-color has-poppins-font-family" style="color:#676767;margin-top:0;margin-right:0;margin-bottom:0;margin-left:0;padding-top:0;padding-right:0;padding-bottom:0;padding-left:0;font-size:15px;font-style:Thin;font-weight:300"><?php esc_html_e('Car dealer support in text listing refers to SMS and chat templates','automotive-car-dealer'); ?></p>
<!-- /wp:paragraph -->

<!-- wp:woocommerce/product-collection {"queryId":4,"query":{"perPage":10,"pages":1,"offset":0,"postType":"product","order":"desc","orderBy":"date","search":"","exclude":[],"inherit":false,"taxQuery":[],"isProductCollectionBlock":true,"featured":false,"woocommerceOnSale":false,"woocommerceStockStatus":["instock","outofstock","onbackorder"],"woocommerceAttributes":[],"woocommerceHandPickedProducts":[],"timeFrame":{"operator":"in","value":"-7 days"},"filterable":false,"relatedBy":{"categories":true,"tags":true}},"tagName":"div","displayLayout":{"type":"flex","columns":4,"shrinkColumns":true},"dimensions":{"widthType":"fill"},"collection":"woocommerce/product-collection/new-arrivals","hideControls":["inherit","order","filterable"],"queryContextIncludes":["collection"],"__privatePreviewState":{"isPreview":false,"previewMessage":"Actual products will vary depending on the page being viewed."},"layout":{"type":"constrained","contentSize":"100%"}} -->
<div class="wp-block-woocommerce-product-collection"><!-- wp:woocommerce/product-template -->
<!-- wp:group {"className":"main-product-grp","style":{"spacing":{"margin":{"top":"0","bottom":"0"},"padding":{"right":"20px","left":"20px","top":"15px","bottom":"15px"}},"border":{"radius":{"topLeft":"10px","topRight":"10px","bottomLeft":"10px","bottomRight":"10px"}}},"backgroundColor":"background","layout":{"type":"constrained"}} -->
<div class="wp-block-group main-product-grp has-background-background-color has-background" style="border-top-left-radius:10px;border-top-right-radius:10px;border-bottom-left-radius:10px;border-bottom-right-radius:10px;margin-top:0;margin-bottom:0;padding-top:15px;padding-right:20px;padding-bottom:15px;padding-left:20px"><!-- wp:post-title {"textAlign":"left","level":3,"isLink":true,"style":{"spacing":{"margin":{"bottom":"0.75rem","top":"0"}},"typography":{"lineHeight":"1.4","fontSize":"25px","fontStyle":"Thin","fontWeight":"500"},"color":{"text":"#121212"},"elements":{"link":{"color":{"text":"#121212"}}}},"fontFamily":"Outfit","__woocommerceNamespace":"woocommerce/product-collection/product-title"} /-->

<!-- wp:woocommerce/product-description {"className":"product-contents","style":{"typography":{"fontSize":"14px","fontStyle":"Thin","fontWeight":"400"},"spacing":{"padding":{"top":"0","bottom":"0","left":"0","right":"0"},"margin":{"top":"0","bottom":"0","left":"0","right":"0"}}},"fontFamily":"Poppins"} /-->

<!-- wp:group {"style":{"spacing":{"blockGap":"0","margin":{"top":"1em","bottom":"1em"},"padding":{"right":"0","left":"0","top":"0","bottom":"0"}}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group" style="margin-top:1em;margin-bottom:1em;padding-top:0;padding-right:0;padding-bottom:0;padding-left:0"><!-- wp:woocommerce/product-image {"showSaleBadge":false,"imageSizing":"thumbnail","isDescendentOfQueryLoop":true,"className":"product-main-imgs"} -->
<!-- wp:woocommerce/product-sale-badge {"align":"right"} /-->
<!-- /wp:woocommerce/product-image --></div>
<!-- /wp:group -->

<!-- wp:woocommerce/product-price {"isDescendentOfQueryLoop":true,"textAlign":"left","textColor":"primary","className":"product-main-price","fontFamily":"Outfit","style":{"elements":{"link":{"color":{"text":"var:preset|color|primary"}}},"typography":{"fontSize":"24px","fontStyle":"Thin","fontWeight":"500"}}} /-->

<!-- wp:woocommerce/product-summary {"isDescendentOfQueryLoop":true,"className":"main-product-summary","fontFamily":"Poppins","style":{"color":{"text":"#676767"},"elements":{"link":{"color":{"text":"#676767"}}},"typography":{"fontSize":"16px","fontStyle":"Thin","fontWeight":"400"},"spacing":{"padding":{"top":"0","bottom":"0","left":"0","right":"0"},"margin":{"right":"0","left":"0","top":"0","bottom":"0"}}}} /--></div>
<!-- /wp:group -->
<!-- /wp:woocommerce/product-template --></div>
<!-- /wp:woocommerce/product-collection --></main>
<!-- /wp:group -->

<?php } else { ?>

<!-- wp:group {"tagName":"main","className":"product-sec","style":{"spacing":{"padding":{"top":"5em","bottom":"5em","left":"0","right":"0"},"margin":{"top":"0","bottom":"0"}}},"backgroundColor":"body-color","layout":{"type":"constrained","contentSize":"80%"}} -->
<main class="wp-block-group product-sec has-body-color-background-color has-background" style="margin-top:0;margin-bottom:0;padding-top:5em;padding-right:0;padding-bottom:5em;padding-left:0"><!-- wp:group {"className":"product-top-title-grp","style":{"spacing":{"padding":{"top":"0","bottom":"0","left":"0","right":"0"},"margin":{"top":"0","bottom":"0"}}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group product-top-title-grp" style="margin-top:0;margin-bottom:0;padding-top:0;padding-right:0;padding-bottom:0;padding-left:0"><!-- wp:paragraph {"className":"product-top-tite","style":{"typography":{"textAlign":"center","fontSize":"17px","fontStyle":"normal","fontWeight":"400"},"elements":{"link":{"color":{"text":"var:preset|color|primary"}}}},"textColor":"primary","fontFamily":"poppins"} -->
<p class="has-text-align-center product-top-tite has-primary-color has-text-color has-link-color has-poppins-font-family" style="font-size:17px;font-style:normal;font-weight:400"><?php esc_html_e('CAR PARTS','automotive-car-dealer'); ?></p>
<!-- /wp:paragraph --></div>
<!-- /wp:group -->

<!-- wp:heading {"style":{"elements":{"link":{"color":{"text":"var:preset|color|secondary"}}},"typography":{"textAlign":"center","fontSize":"33px","fontStyle":"normal","fontWeight":"700"},"spacing":{"padding":{"top":"0","bottom":"0","left":"0","right":"0"},"margin":{"top":"0","bottom":"0","left":"0","right":"0"}}},"textColor":"secondary","fontFamily":"Outfit"} -->
<h2 class="wp-block-heading has-text-align-center has-secondary-color has-text-color has-link-color has-outfit-font-family" style="margin-top:0;margin-right:0;margin-bottom:0;margin-left:0;padding-top:0;padding-right:0;padding-bottom:0;padding-left:0;font-size:33px;font-style:normal;font-weight:700"><?php esc_html_e('Power in Every Part','automotive-car-dealer'); ?></h2>
<!-- /wp:heading -->

<!-- wp:paragraph {"className":"product-para","style":{"typography":{"textAlign":"center","fontSize":"15px","fontStyle":"Thin","fontWeight":"300"},"color":{"text":"#676767"},"elements":{"link":{"color":{"text":"#676767"}}},"spacing":{"padding":{"top":"0","bottom":"0","left":"0","right":"0"},"margin":{"top":"0","bottom":"0","left":"0","right":"0"}}},"fontFamily":"Poppins"} -->
<p class="has-text-align-center product-para has-text-color has-link-color has-poppins-font-family" style="color:#676767;margin-top:0;margin-right:0;margin-bottom:0;margin-left:0;padding-top:0;padding-right:0;padding-bottom:0;padding-left:0;font-size:15px;font-style:Thin;font-weight:300"><?php esc_html_e('Car dealer support in text listing refers to SMS and chat templates','automotive-car-dealer'); ?></p>
<!-- /wp:paragraph -->

<!-- wp:columns -->
<div class="wp-block-columns"><!-- wp:column {"width":"25%"} -->
<div class="wp-block-column" style="flex-basis:25%"><!-- wp:group {"className":"main-product-grp","style":{"border":{"radius":{"topLeft":"10px","topRight":"10px","bottomLeft":"10px","bottomRight":"10px"}},"spacing":{"padding":{"top":"15px","bottom":"15px","left":"20px","right":"20px"}}},"backgroundColor":"background","layout":{"type":"constrained"}} -->
<div class="wp-block-group main-product-grp has-background-background-color has-background" style="border-top-left-radius:10px;border-top-right-radius:10px;border-bottom-left-radius:10px;border-bottom-right-radius:10px;padding-top:15px;padding-right:20px;padding-bottom:15px;padding-left:20px"><!-- wp:heading {"level":3,"style":{"color":{"text":"#121212"},"elements":{"link":{"color":{"text":"#121212"}}},"typography":{"fontSize":"20px","fontStyle":"Thin","fontWeight":"600"}},"fontFamily":"Outfit"} -->
<h3 class="wp-block-heading has-text-color has-link-color has-outfit-font-family" style="color:#121212;font-size:20px;font-style:Thin;font-weight:600"><?php esc_html_e('Car Parts Mufflers And Pipes','automotive-car-dealer'); ?></h3>
<!-- /wp:heading -->

<!-- wp:paragraph {"className":"product-contents","style":{"spacing":{"padding":{"top":"0","bottom":"0","left":"0","right":"0"},"margin":{"top":"0","bottom":"0","left":"0","right":"0"}},"typography":{"fontSize":"15px","fontStyle":"Thin","fontWeight":"400"},"color":{"text":"#676767"},"elements":{"link":{"color":{"text":"#676767"}}}},"fontFamily":"Poppins"} -->
<p class="product-contents has-text-color has-link-color has-poppins-font-family" style="color:#676767;margin-top:0;margin-right:0;margin-bottom:0;margin-left:0;padding-top:0;padding-right:0;padding-bottom:0;padding-left:0;font-size:15px;font-style:Thin;font-weight:400"><?php esc_html_e('Designed for Lex H‑21 Vehicles','automotive-car-dealer'); ?></p>
<!-- /wp:paragraph -->

<!-- wp:group {"className":"product-main-imgs","style":{"spacing":{"padding":{"right":"0","left":"0","top":"0","bottom":"0"},"margin":{"top":"12px","bottom":"12px"}}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group product-main-imgs" style="margin-top:12px;margin-bottom:12px;padding-top:0;padding-right:0;padding-bottom:0;padding-left:0"><!-- wp:image {"id":2031,"sizeSlug":"full","linkDestination":"none"} -->
<figure class="wp-block-image size-full"><img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/product-img1.png'); ?>" alt="" class="wp-image-2031"/></figure>
<!-- /wp:image --></div>
<!-- /wp:group -->

<!-- wp:paragraph {"className":"product-main-price","style":{"elements":{"link":{"color":{"text":"var:preset|color|primary"}}},"typography":{"fontSize":"24px","fontStyle":"Thin","fontWeight":"500"},"spacing":{"padding":{"top":"0","bottom":"0","left":"0","right":"0"},"margin":{"top":"0","bottom":"0","left":"0","right":"0"}}},"textColor":"primary","fontFamily":"Outfit"} -->
<p class="product-main-price has-primary-color has-text-color has-link-color has-outfit-font-family" style="margin-top:0;margin-right:0;margin-bottom:0;margin-left:0;padding-top:0;padding-right:0;padding-bottom:0;padding-left:0;font-size:24px;font-style:Thin;font-weight:500"><?php esc_html_e('$18.00','automotive-car-dealer'); ?></p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"className":"main-product-summary","style":{"spacing":{"padding":{"top":"0","bottom":"0","left":"0","right":"0"},"margin":{"top":"0","bottom":"0","left":"0","right":"0"}},"typography":{"fontSize":"15px","fontStyle":"Thin","fontWeight":"400"},"color":{"text":"#676767"},"elements":{"link":{"color":{"text":"#676767"}}}},"fontFamily":"Poppins"} -->
<p class="main-product-summary has-text-color has-link-color has-poppins-font-family" style="color:#676767;margin-top:0;margin-right:0;margin-bottom:0;margin-left:0;padding-top:0;padding-right:0;padding-bottom:0;padding-left:0;font-size:15px;font-style:Thin;font-weight:400"><?php esc_html_e('Available Finance Plans via Partner Institutions','automotive-car-dealer'); ?></p>
<!-- /wp:paragraph --></div>
<!-- /wp:group --></div>
<!-- /wp:column -->

<!-- wp:column {"width":"25%"} -->
<div class="wp-block-column" style="flex-basis:25%"><!-- wp:group {"className":"main-product-grp","style":{"border":{"radius":{"topLeft":"10px","topRight":"10px","bottomLeft":"10px","bottomRight":"10px"}},"spacing":{"padding":{"top":"15px","bottom":"15px","left":"20px","right":"20px"}}},"backgroundColor":"background","layout":{"type":"constrained"}} -->
<div class="wp-block-group main-product-grp has-background-background-color has-background" style="border-top-left-radius:10px;border-top-right-radius:10px;border-bottom-left-radius:10px;border-bottom-right-radius:10px;padding-top:15px;padding-right:20px;padding-bottom:15px;padding-left:20px"><!-- wp:heading {"level":3,"style":{"color":{"text":"#121212"},"elements":{"link":{"color":{"text":"#121212"}}},"typography":{"fontSize":"20px","fontStyle":"Thin","fontWeight":"600"}},"fontFamily":"Outfit"} -->
<h3 class="wp-block-heading has-text-color has-link-color has-outfit-font-family" style="color:#121212;font-size:20px;font-style:Thin;font-weight:600"><?php esc_html_e('Syntetic Oil 5W-40','automotive-car-dealer'); ?></h3>
<!-- /wp:heading -->

<!-- wp:paragraph {"className":"product-contents","style":{"spacing":{"padding":{"top":"0","bottom":"0","left":"0","right":"0"},"margin":{"top":"0","bottom":"0","left":"0","right":"0"}},"typography":{"fontSize":"15px","fontStyle":"Thin","fontWeight":"400"},"color":{"text":"#676767"},"elements":{"link":{"color":{"text":"#676767"}}}},"fontFamily":"Poppins"} -->
<p class="product-contents has-text-color has-link-color has-poppins-font-family" style="color:#676767;margin-top:0;margin-right:0;margin-bottom:0;margin-left:0;padding-top:0;padding-right:0;padding-bottom:0;padding-left:0;font-size:15px;font-style:Thin;font-weight:400"><?php esc_html_e('Designed for Lex H‑21 Vehicles','automotive-car-dealer'); ?></p>
<!-- /wp:paragraph -->

<!-- wp:group {"className":"product-main-imgs","style":{"spacing":{"padding":{"right":"0","left":"0","top":"0","bottom":"0"},"margin":{"top":"12px","bottom":"12px"}}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group product-main-imgs" style="margin-top:12px;margin-bottom:12px;padding-top:0;padding-right:0;padding-bottom:0;padding-left:0"><!-- wp:image {"id":2031,"sizeSlug":"full","linkDestination":"none"} -->
<figure class="wp-block-image size-full"><img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/product-img2.png'); ?>" alt="" class="wp-image-2031"/></figure>
<!-- /wp:image --></div>
<!-- /wp:group -->

<!-- wp:paragraph {"className":"product-main-price","style":{"elements":{"link":{"color":{"text":"var:preset|color|primary"}}},"typography":{"fontSize":"24px","fontStyle":"Thin","fontWeight":"500"},"spacing":{"padding":{"top":"0","bottom":"0","left":"0","right":"0"},"margin":{"top":"0","bottom":"0","left":"0","right":"0"}}},"textColor":"primary","fontFamily":"Outfit"} -->
<p class="product-main-price has-primary-color has-text-color has-link-color has-outfit-font-family" style="margin-top:0;margin-right:0;margin-bottom:0;margin-left:0;padding-top:0;padding-right:0;padding-bottom:0;padding-left:0;font-size:24px;font-style:Thin;font-weight:500"><?php esc_html_e('$18.00','automotive-car-dealer'); ?></p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"className":"main-product-summary","style":{"spacing":{"padding":{"top":"0","bottom":"0","left":"0","right":"0"},"margin":{"top":"0","bottom":"0","left":"0","right":"0"}},"typography":{"fontSize":"15px","fontStyle":"Thin","fontWeight":"400"},"color":{"text":"#676767"},"elements":{"link":{"color":{"text":"#676767"}}}},"fontFamily":"Poppins"} -->
<p class="main-product-summary has-text-color has-link-color has-poppins-font-family" style="color:#676767;margin-top:0;margin-right:0;margin-bottom:0;margin-left:0;padding-top:0;padding-right:0;padding-bottom:0;padding-left:0;font-size:15px;font-style:Thin;font-weight:400"><?php esc_html_e('Available Finance Plans via Partner Institutions','automotive-car-dealer'); ?></p>
<!-- /wp:paragraph --></div>
<!-- /wp:group --></div>
<!-- /wp:column -->

<!-- wp:column {"width":"25%"} -->
<div class="wp-block-column" style="flex-basis:25%"><!-- wp:group {"className":"main-product-grp","style":{"border":{"radius":{"topLeft":"10px","topRight":"10px","bottomLeft":"10px","bottomRight":"10px"}},"spacing":{"padding":{"top":"15px","bottom":"15px","left":"20px","right":"20px"}}},"backgroundColor":"background","layout":{"type":"constrained"}} -->
<div class="wp-block-group main-product-grp has-background-background-color has-background" style="border-top-left-radius:10px;border-top-right-radius:10px;border-bottom-left-radius:10px;border-bottom-right-radius:10px;padding-top:15px;padding-right:20px;padding-bottom:15px;padding-left:20px"><!-- wp:heading {"level":3,"style":{"color":{"text":"#121212"},"elements":{"link":{"color":{"text":"#121212"}}},"typography":{"fontSize":"20px","fontStyle":"Thin","fontWeight":"600"}},"fontFamily":"Outfit"} -->
<h3 class="wp-block-heading has-text-color has-link-color has-outfit-font-family" style="color:#121212;font-size:20px;font-style:Thin;font-weight:600"><?php esc_html_e('High-Performance Tires','automotive-car-dealer'); ?></h3>
<!-- /wp:heading -->

<!-- wp:paragraph {"className":"product-contents","style":{"spacing":{"padding":{"top":"0","bottom":"0","left":"0","right":"0"},"margin":{"top":"0","bottom":"0","left":"0","right":"0"}},"typography":{"fontSize":"15px","fontStyle":"Thin","fontWeight":"400"},"color":{"text":"#676767"},"elements":{"link":{"color":{"text":"#676767"}}}},"fontFamily":"Poppins"} -->
<p class="product-contents has-text-color has-link-color has-poppins-font-family" style="color:#676767;margin-top:0;margin-right:0;margin-bottom:0;margin-left:0;padding-top:0;padding-right:0;padding-bottom:0;padding-left:0;font-size:15px;font-style:Thin;font-weight:400"><?php esc_html_e('Designed for Lex H‑21 Vehicles','automotive-car-dealer'); ?></p>
<!-- /wp:paragraph -->

<!-- wp:group {"className":"product-main-imgs","style":{"spacing":{"padding":{"right":"0","left":"0","top":"0","bottom":"0"},"margin":{"top":"12px","bottom":"12px"}}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group product-main-imgs" style="margin-top:12px;margin-bottom:12px;padding-top:0;padding-right:0;padding-bottom:0;padding-left:0"><!-- wp:image {"id":2031,"sizeSlug":"full","linkDestination":"none"} -->
<figure class="wp-block-image size-full"><img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/product-img3.png'); ?>" alt="" class="wp-image-2031"/></figure>
<!-- /wp:image --></div>
<!-- /wp:group -->

<!-- wp:paragraph {"className":"product-main-price","style":{"elements":{"link":{"color":{"text":"var:preset|color|primary"}}},"typography":{"fontSize":"24px","fontStyle":"Thin","fontWeight":"500"},"spacing":{"padding":{"top":"0","bottom":"0","left":"0","right":"0"},"margin":{"top":"0","bottom":"0","left":"0","right":"0"}}},"textColor":"primary","fontFamily":"Outfit"} -->
<p class="product-main-price has-primary-color has-text-color has-link-color has-outfit-font-family" style="margin-top:0;margin-right:0;margin-bottom:0;margin-left:0;padding-top:0;padding-right:0;padding-bottom:0;padding-left:0;font-size:24px;font-style:Thin;font-weight:500"><?php esc_html_e('$18.00','automotive-car-dealer'); ?></p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"className":"main-product-summary","style":{"spacing":{"padding":{"top":"0","bottom":"0","left":"0","right":"0"},"margin":{"top":"0","bottom":"0","left":"0","right":"0"}},"typography":{"fontSize":"15px","fontStyle":"Thin","fontWeight":"400"},"color":{"text":"#676767"},"elements":{"link":{"color":{"text":"#676767"}}}},"fontFamily":"Poppins"} -->
<p class="main-product-summary has-text-color has-link-color has-poppins-font-family" style="color:#676767;margin-top:0;margin-right:0;margin-bottom:0;margin-left:0;padding-top:0;padding-right:0;padding-bottom:0;padding-left:0;font-size:15px;font-style:Thin;font-weight:400"><?php esc_html_e('Available Finance Plans via Partner Institutions','automotive-car-dealer'); ?></p>
<!-- /wp:paragraph --></div>
<!-- /wp:group --></div>
<!-- /wp:column -->

<!-- wp:column {"width":"25%"} -->
<div class="wp-block-column" style="flex-basis:25%"><!-- wp:group {"className":"main-product-grp","style":{"border":{"radius":{"topLeft":"10px","topRight":"10px","bottomLeft":"10px","bottomRight":"10px"}},"spacing":{"padding":{"top":"15px","bottom":"15px","left":"20px","right":"20px"}}},"backgroundColor":"background","layout":{"type":"constrained"}} -->
<div class="wp-block-group main-product-grp has-background-background-color has-background" style="border-top-left-radius:10px;border-top-right-radius:10px;border-bottom-left-radius:10px;border-bottom-right-radius:10px;padding-top:15px;padding-right:20px;padding-bottom:15px;padding-left:20px"><!-- wp:heading {"level":3,"style":{"color":{"text":"#121212"},"elements":{"link":{"color":{"text":"#121212"}}},"typography":{"fontSize":"20px","fontStyle":"Thin","fontWeight":"600"}},"fontFamily":"Outfit"} -->
<h3 class="wp-block-heading has-text-color has-link-color has-outfit-font-family" style="color:#121212;font-size:20px;font-style:Thin;font-weight:600"><?php esc_html_e('Ninja Rims R20 1 Strada Nera','automotive-car-dealer'); ?></h3>
<!-- /wp:heading -->

<!-- wp:paragraph {"className":"product-contents","style":{"spacing":{"padding":{"top":"0","bottom":"0","left":"0","right":"0"},"margin":{"top":"0","bottom":"0","left":"0","right":"0"}},"typography":{"fontSize":"15px","fontStyle":"Thin","fontWeight":"400"},"color":{"text":"#676767"},"elements":{"link":{"color":{"text":"#676767"}}}},"fontFamily":"Poppins"} -->
<p class="product-contents has-text-color has-link-color has-poppins-font-family" style="color:#676767;margin-top:0;margin-right:0;margin-bottom:0;margin-left:0;padding-top:0;padding-right:0;padding-bottom:0;padding-left:0;font-size:15px;font-style:Thin;font-weight:400"><?php esc_html_e('Designed for Lex H‑21 Vehicles','automotive-car-dealer'); ?></p>
<!-- /wp:paragraph -->

<!-- wp:group {"className":"product-main-imgs","style":{"spacing":{"padding":{"right":"0","left":"0","top":"0","bottom":"0"},"margin":{"top":"12px","bottom":"12px"}}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group product-main-imgs" style="margin-top:12px;margin-bottom:12px;padding-top:0;padding-right:0;padding-bottom:0;padding-left:0"><!-- wp:image {"id":2031,"sizeSlug":"full","linkDestination":"none"} -->
<figure class="wp-block-image size-full"><img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/product-img4.png'); ?>" alt="" class="wp-image-2031"/></figure>
<!-- /wp:image --></div>
<!-- /wp:group -->

<!-- wp:paragraph {"className":"product-main-price","style":{"elements":{"link":{"color":{"text":"var:preset|color|primary"}}},"typography":{"fontSize":"24px","fontStyle":"Thin","fontWeight":"500"},"spacing":{"padding":{"top":"0","bottom":"0","left":"0","right":"0"},"margin":{"top":"0","bottom":"0","left":"0","right":"0"}}},"textColor":"primary","fontFamily":"Outfit"} -->
<p class="product-main-price has-primary-color has-text-color has-link-color has-outfit-font-family" style="margin-top:0;margin-right:0;margin-bottom:0;margin-left:0;padding-top:0;padding-right:0;padding-bottom:0;padding-left:0;font-size:24px;font-style:Thin;font-weight:500"><?php esc_html_e('$18.00','automotive-car-dealer'); ?></p>
<!-- /wp:paragraph -->

<!-- wp:paragraph {"className":"main-product-summary","style":{"spacing":{"padding":{"top":"0","bottom":"0","left":"0","right":"0"},"margin":{"top":"0","bottom":"0","left":"0","right":"0"}},"typography":{"fontSize":"15px","fontStyle":"Thin","fontWeight":"400"},"color":{"text":"#676767"},"elements":{"link":{"color":{"text":"#676767"}}}},"fontFamily":"Poppins"} -->
<p class="main-product-summary has-text-color has-link-color has-poppins-font-family" style="color:#676767;margin-top:0;margin-right:0;margin-bottom:0;margin-left:0;padding-top:0;padding-right:0;padding-bottom:0;padding-left:0;font-size:15px;font-style:Thin;font-weight:400"><?php esc_html_e('Available Finance Plans via Partner Institutions','automotive-car-dealer'); ?></p>
<!-- /wp:paragraph --></div>
<!-- /wp:group --></div>
<!-- /wp:column --></div>
<!-- /wp:columns --></main>
<!-- /wp:group -->

<?php } ?>