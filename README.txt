=== Vector Search With Typesense ===
Contributors: knowhalim
Donate link: https://knowhalim.com/
Tags: vector search, typesense, semantic
Requires at least: 6.4.0
Tested up to: 6.5
Stable tag: 1.0.0
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Display a vector search widget using Typesense and OpenAI embedding model using the shortcode [tswp_search].

== Description ==

**Elevate Your WordPress Search Experience**
Transform your WordPress site with advanced search capabilities using our Vector Search with Typesense plugin. Leveraging the power of OpenAI’s cutting-edge embedding models and the ultra-fast, typo-tolerant search engine Typesense, this plugin offers a seamless integration to enhance user search experience dramatically.

The Vector Search With Typesense plugin integrates OpenAI embedding model before inserting into your self-hosted Typesense instance using OpenAI API. This plugin is currently only supports the posts post type. To display the search form, using the shortcake [tswp_search].

Before installing the plugin, you will need to install Typesense in your own server and install the official Typesense plugin beforehand.

**Features**

*   **OpenAI Integration:** Utilizes OpenAI’s embedding models to analyze and index post content, enabling highly relevant search results based on content semantics rather than mere keyword matches.
*   **Powered by Typesense:** Experience lightning-fast search responses with Typesense, which is designed for instant, typo-tolerant search across large volumes of data.
*   **Easy to Use:** Simple to install and configure with the provided shortcake [tswp_search] to add a search form anywhere on your site.

**Installation Requirements**
Before enjoying the enhanced search capabilities of Vector Search with Typesense, ensure you meet the following prerequisites:

**Self-hosted Typesense Server:** Vector Search requires a self-hosted Typesense server. Setting up your own instance ensures full control over your data and search performance.
**Typesense Plugin:** Install the official Typesense plugin for WordPress as a prerequisite to integrate smoothly and harness the full potential of vectorized search capabilities.

##Benefits:
* Improved Search Accuracy: By embedding the content semantically, users receive more accurate and contextually relevant search results.
* Enhanced User Experience: The fast and intuitive search interface keeps users engaged and improves overall site navigation.

**OPEN AI**
Vector Search With Typesense utilizes the Embedding model from OpenAI from OpenAI via API endpoint. This plugin does not gather any information from your OpenAI account except for the number of tokens utilized. The data transmitted to the OpenAI servers primarily consists of the content of your article and the context you specify. It is important to check your [API usage](https://beta.openai.com/account/usage "OpenAI API Usage") on the [OpenAI](https://openai.com/blog/openai-api "OpenAI API") website for accurate information. Please also review their [Privacy Policy](https://openai.com/privacy/ "privacy policy") and [Terms of Service](https://openai.com/terms/ "TOS") for further information.

##Disclaimer
Vector Search With Typesense is a plugin that helps to create a semantic search function in Wordpress using OpenAI embedding model and Typesense. By using this plugin, users agree to monitor their own OpenAI usage and handle any problems or misuse by their visitors. The developer of WP Vector Search With Typesense and related parties are not responsible for any issues or losses caused by using the plugin.


== Installation ==

To install this plugin, follow these steps:

1. Download the plugin archive and extract it.
2. Upload the extracted directory to your `/wp-content/plugins/` directory.
3. **Activate the plugin** through the 'Plugins' menu in WordPress.
4. Configure the plugin by going to the **Vector Search Settings** page.

== Frequently Asked Questions ==

= How do I install Typesense? =

Go to https://typesense.org/docs/guide/install-typesense.html to install Typesense on your server.

= Do you have a tutorial on how to configure all of this? =

Yes but it is still in the making
