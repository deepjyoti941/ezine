<div class="row">
	<div class="span12" style="background-color:#E3FFC5;">
	<table class="table" >
    <thead>
      <tr>
        <th>ID</th>
        <th>Title</th>
        <th>Issue/Periodicity</th>
        <th>Category</th>
        <th>Issue Date</th>
        <th>Created</th>
        <th>&nbsp;</th>
      </tr>
    </thead>
    <tbody>
      <? foreach ($magazines as $magazine) { ?>
      <tr>
        <td><?= $magazine->id ?></td>
        <td><?= $magazine->magazine_name ?></td>
        <td><?= $magazine->issue ?></td>
        <td><?= $magazine->category_name?></td>
        <td><?= $magazine->issue_date ?></td>
        <td><?= $magazine->created_at ?></td>
        <td><a href="/magazine/<?= $magazine->id ?>/edit">Edit</a></td>
      </tr>
      <? } ?>
    </tbody>
  </table>
		
	</div>
</div>