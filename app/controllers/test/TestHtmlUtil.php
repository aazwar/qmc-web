<?php
namespace Test;

class TestHtmlUtil extends \Fuwafuwa\Controller {
  function testRadio() {
    $f3 = \Base::instance();
    $p = \Preview::instance();
    $content = '{{ HtmlUtil::radio("test", ["a", "b"], ["A *", "B *"]); }}';
    print "<pre>";
    print $p->resolve($content);
    print "</pre>";
  }
}
