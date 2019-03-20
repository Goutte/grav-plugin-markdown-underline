<?php

namespace Grav\Plugin;

use Grav\Common\Plugin;
use RocketTheme\Toolbox\Event\Event;

/**
 * Customize the HTML tags to use with the usual inline emphasis and strong blocks.
 *
 * - *
 * - **
 * - _
 * - __
 *
 *
 * __some text__ => <u>some text</u>
 *
 * Use with caution, as underlining makes text harder to read.
 * If you don't think so, please be thankful for your great sight and ortholexia.
 *
 * Not sure how this will fare with multibyte strings. Possibly badly.
 * Try mb_strlen ?
 *
 * Class MarkdownUnderlinePlugin
 * @package Grav\Plugin
 */
class MarkdownUnderlinePlugin extends Plugin
{
    /**
     * @return array
     *
     * The getSubscribedEvents() gives the core a list of events
     *     that the plugin wants to listen to. The key of each
     *     array section is the event that the plugin listens to
     *     and the value (in the form of an array) contains the
     *     callable (or function) as well as the priority. The
     *     higher the number the higher the priority.
     */
    public static function getSubscribedEvents()
    {
        return [
            'onPluginsInitialized' => ['onPluginsInitialized', 0]
        ];
    }

    /**
     * Initialize the plugin
     */
    public function onPluginsInitialized()
    {
        // Don't proceed if we are in the admin plugin.
        // Since we don't sanitize the configuration options, this is paramount.
        // This way, if the plugin breaks pages somehow, admin will still be available.
        if ($this->isAdmin()) {
            return;
        }

        // *Subscribe* to the main event we are interested in.
        $this->enable([
            'onMarkdownInitialized' => ['onMarkdownInitialized', 0],
        ]);
    }

    public function onMarkdownInitialized(Event $event)
    {
        $markdown = $event['markdown'];
        $config = $this->config;
        $mu_config = $config->get('plugins.markdown-underline');

        // This feature depends on the page being provided in onMarkdownInitialized event.
        // There may be a PR for this in the future. Not sure about the implications.
        if (isset($event['page'])) {
            $config = $this->mergeConfig($event['page']);
            // Merging works but changes paths
            $mu_config = array(
                '*' => $config->get('*'),
                '**' => $config->get('**'),
                '_' => $config->get('_'),
                '__' => $config->get('__'),
            );
        }

        // Add our parser right before the Emphasis one.
        // See vendor/erusev/parsedown/Parsedown.php#L977
        $markdown->addInlineType('_', 'PluginUnderline', 0);
        $markdown->addInlineType('*', 'PluginUnderline', 0);

        $inlineUnderline = function ($Excerpt) use ($mu_config) {

//            if (strlen($Excerpt['text']) < 2) {
//                return;
//            }
            if ( ! isset($Excerpt['text'][1])) {
                return;
            }

            $marker = $Excerpt['text'][0];

            if ($Excerpt['text'][1] === $marker and preg_match($this->StrongRegex[$marker], $Excerpt['text'], $matches)) {
                if ($marker === '_') {
                    $tag = $mu_config['__'];
                } else {
                    $tag = $mu_config['**'];
                }
            } elseif (preg_match($this->EmRegex[$marker], $Excerpt['text'], $matches)) {
                if ($marker === '_') {
                    $tag = $mu_config['_'];
                } else {
                    $tag = $mu_config['*'];
                }
            } else {
                return;
            }

            return array(
                'extent' => strlen($matches[0]),
                'element' => array(
                    'name' => $tag,
                    'handler' => 'line',
                    'text' => $matches[1],
                ),
            );


        };

        $markdown->inlinePluginUnderline = $inlineUnderline->bindTo($markdown, $markdown);
    }

}
