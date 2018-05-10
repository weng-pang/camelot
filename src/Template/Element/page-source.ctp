<?php if ($settings->is_demo_site): ?>
    Source code ::
    <a href="https://git.infotech.monash.edu/UGIE/cms/blob/master/src/Controller/<?= $this->request->getParam('controller') ?>Controller.php">
        <code>[<?= $this->request->getParam('controller') ?>Controller.php]</code></a>
    ::
    <a href="https://git.infotech.monash.edu/UGIE/cms/blob/master/src/Controller/<?= $this->request->getParam('controller') ?>Controller.php">
        <code>[<?= $this->request->getParam('action') ?>()]</code></a>
    ::
    <a href="https://git.infotech.monash.edu/UGIE/cms/blob/master/src/Template/<?= $this->templatePath ?>/<?= $this->getTemplate() ?>.ctp">
        <code>[<?= $this->templatePath ?>/<?= $this->getTemplate() ?>.ctp]</code></a>
    ::
    <a href="https://git.infotech.monash.edu/UGIE/cms/blob/master/src/Template/Layout/<?= $this->layout ?>.ctp">
        <code>[Layout/<?= $this->layout ?>.ctp]</code></a>
<?php endif ?>