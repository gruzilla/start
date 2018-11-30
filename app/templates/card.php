      <div id="<?php echo $id; ?>" class="content-column mdl-cell mdl-cell--4-col mdl-cell--4-col-tablet mdl-cell--4-col-phone">
        <div class="card-event mdl-card mdl-shadow--2dp">
          <div class="mdl-card__title mdl-card--expand">
            <h4><?php echo $title; ?></h4>
          </div>
          <div class="mdl-card__supporting-text">
            <ul class="mdl-list">
            <?php foreach ($longTermGoals as $goal) { ?>
            <li class="mdl-list__item">
              <span class="mdl-list__item-primary-content">
              <?php echo $goal['goal_name'] ?><br />
              </span>
            </li>
            <?php } ?>
            </ul>
            <ul class="mdl-list">
            <?php foreach ($shortTermGoals as $goal) { ?>
            <li class="mdl-list__item">
              <span class="mdl-list__item-primary-content"><small>
              <?php echo $goal['goal_name'] ?></small><br />
              </span>
            </li>
            <?php } ?>
            </ul>
          </div>
          <div class="mdl-card__actions mdl-card--border">
            <?php foreach ($tags as $tag) { ?>
            <span class="mdl-chip">
              <span class="mdl-chip__text"><?php echo $tag['tag_name'] ?></span>
            </span>
            <?php } ?>
            <div class="mdl-layout-spacer"></div>
            <a class="mdl-button mdl-button--colored mdl-js-button mdl-js-ripple-effect js-log">
              <i class="material-icons">assignment</i>
            </a>
          </div>
        </div>
      </div>
