<?=$this->load->view('header')?>

<section id="main">
    <div class="page_title">
        <?php if($model->ShowTitle){?> <h2><?=$model->PageName?></h2> <?php } ?>
    </div>
    <section id="main_content" class="main_content">
        <?=parse_form($model -> CSS) ?>
        <?php 
            $content = parse_form($model -> HTML);
            $content = $this->shortcodes->parse($content);
            echo $content;
        ?>
        <?=parse_form($model -> Javascript) ?>
    </section>
</section>

<?=$this->load->view('footer')?>
