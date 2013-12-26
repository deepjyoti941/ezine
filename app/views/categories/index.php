<div class="row">
  <div class="span12" style="background-color:#E3FFC5;">
  <table class="table">
    <thead>
      <tr>
        <th>ID</th>
        <th>Category Name</th>
        <th>Created</th>
        <th>&nbsp;</th>
        <th>&nbsp;</th>
      </tr>
    </thead>
    <tbody>
      <? foreach ($magazineCategory as $category) { ?>
      <tr>
        <td><?= $category->id ?></td>
        <td><?= $category->category_name ?></td>
        <td><?= $category->created_at ?></td>
        <td><a href="/category/<?= $category->id  ?>/delete">Delete</a></td>
        <td><a href="/category/<?= $category->id  ?>/edit">Edit</a></td>
      </tr>
      <? } ?>
    </tbody>
  </table>   
  </div>
</div>
