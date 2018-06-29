<?php

namespace App\Model\Entity;

use Cake\Collection\Collection;
use Cake\ORM\Entity;

/**
 * @property int $id
 * @property string $title
 * @property string $body
 * @property string $slug
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 *
 * @property \App\Model\Entity\Article[] $articles
 */
class Article extends Entity
{
    protected $_accessible = [
        '*' => true,
        'id' => false,
    ];

    protected function _getTagString()
    {
        if (isset($this->_properties['tag_string'])) {
            return $this->_properties['tag_string'];
        }
        if (empty($this->tags)) {
            return '';
        }
        $tags = new Collection($this->tags);
        $str = $tags->reduce(function ($string, $tag) {
            return $string . $tag->title . ', ';
        }, '');
        return trim($str, ', ');
    }

    /**
     * As a general rule, we NEVER TRUST ANY USER INPUT. Especially if that user input is going to be displayed publicly
     * to other users. This opens us up to "Cross Site Scripting" (XSS) attacks. Imagine if we let someone enter the
     * following title for an article, then we displayed that to another user who visited the site:
     *
     *    "Article <script>document.location = 'http://fake-paypal-site-to-steal-your-credit-card-info.com'</script>"
     *
     * When we show this article to a user (e.g. when they view /articles/view/blah) in their browser, it will redirect
     * them to a scam, where they may have their identity or money stolen, or have a virus installed on their computer.
     * This would not only be disasterous for your user, but it reflects extremely poorly on your website.
     *
     * To avoid this, we generally would make sure to "escape" any user generated data before putting it into HTML to
     * be shown to users. This is done in CakePHP templates by using the h() function. This is why you see the following
     * in the baked templates:
     *
     *   <?= h($article->body) ?>
     *
     * Instead of just outputing the body directly:
     *
     *   <?= $article->body ?>
     *
     * What does escaped data look like? It replaces any < tag with &lt; and any > tag with &gt;. These symbols will
     * now be shown to the user as intended, rather than itnerpreted by the output as valid HTML (and hence the "<script>"
     * block will get executed and direct the users browser to the fake site, using the example above). It also replaces
     * many other things, such as quotes (") with &quot;, as well as other things too.
     *
     * HOWEVER, this not suitable for our article bodies. The reason is that we used the TinyMCE WYSIWYG rich text editor
     * to let the user enter content. In doing so, the editor will use <b> tags for bold text, <ul>, <li>, and <ol> for
     * lists, etc. Thus if we escape the article body, then it will replace <b> with &lt;b&gt;. Instead of showing some
     * text as bold text to the user, it will actually show "<b>" to the user, which is of course not what we want.
     *
     * So, instead of "escaping" the data, we are going to "sanitize" (or "purify") it. This is the process of saying:
     * We accept that some HTML is required to be added by the user (e.g. "<b>"), but there is some that is always
     * going to be unsafe (e.g. <script> tags) and we never want the user to be able to add this type of content to our
     * database. This is a very hard thing to do well, but there is a great library called HTMLPurifier which does it
     * for us in a couple of lines of code.
     *
     * @param $unsafeBodyWithHtml
     * @return string
     */
    protected function _setBody($unsafeBodyWithHtml) {
        $config = \HTMLPurifier_Config::createDefault();

        // Allow iframes from trusted sources (YouTube + Vimeo). Typically embedding iframes is not ideal, because
        // someone could, e.g. embed an iframe to their website which tries to trick the user into paying them money.
        // However, it is quite common to want to embed videos into websites via iframes. This is how YouTube and
        // Vimeo let you embed their videos into other peoples websites.
        // See https://stackoverflow.com/a/12784081 for where this solution came from:
        $config->set('HTML.SafeIframe', true);
        $config->set('URI.SafeIframeRegexp', '%^(https?:)?//(www\.youtube(?:-nocookie)?\.com/embed/|player\.vimeo\.com/video/)%');

        $purifier = new \HTMLPurifier($config);
        return $purifier->purify($unsafeBodyWithHtml);
    }
}
