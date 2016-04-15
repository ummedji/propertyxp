<table>
  <?php if ($records): ?>
    <?php foreach ($records as $record): ?>
      <tr>
        <td class="id">
          <div class="inner">
            <?php print $record->id; ?>
          </div>
        </td>
        <td class="name">
          <div class="inner">
            <?php print $record->name; ?>
          </div>
        </td>
        <td class="label">
          <div class="inner">
            <?php print $record->label; ?>
          </div>
        </td>
        <td class="actions">
          <div class="inner actions">
            <a href="<?php print $recordLinks[$record->id]['edit']; ?>">Edit</a>
            <a href="<?php print $recordLinks[$record->id]['delete']; ?>">Delete</a>
            <a href="<?php print $recordLinks[$record->id]['list']; ?>">Manage</a>

          </div>
        </td>
      </tr>
    <?php endforeach; ?>
  <?php endif; ?>
</table>

<a class="btn button" href="<?php print $createLink; ?>">Create Form</a>