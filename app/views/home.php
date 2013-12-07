
  <div class="span9" style="border: 1px solid #e5e5e5; margin-top: 30px;">
  <div id="magazine_container">
      <? foreach ($magazines as $magazine) {?>
      <? $url = '/'.$magazine->magazine_slug.'/'.$magazine->id ;?>
        <div class="magazineContainer">
          <h3 class="magazineMainCategoryHeight"><a href="<?= $url ?>"><?= $magazine->magazine_name ?></a></h3>
          <div class="magazineImage">
            <a href="<?= $url ?>" title="<?= $magazine->magazine_name ?>" target>
              <span id="">
                <img src="<?= $magazine->img_thumb_path ?>" alt="<?= $magazine->magazine_name ?>" title="<?= $magazine->magazine_name ?>">
              </span>
            </a>
          </div> 
      </div>

      <? }?>
    </div>
</div>

<?
      //$url = '/'.$magazine->magazine_slug.'/'.$magazine->issue.'/'.$magazine->id;

?>