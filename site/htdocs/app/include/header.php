<navbar>
<div class="navbar">
    <div class="navbar-content">
        <div class="icon">
            <div id="logoLink">
                <div class="logo"></div>
            </div>
        </div>

        <ul>
            <?php if (isset($_SESSION['id'])): ?>
                <li><a href="<?php $id_user = $_SESSION['id']; echo BASE_URL . "user/user.php?id=$id_user" ?>" style="font-weight: 800;"><?php echo $_SESSION['username']; ?></a></li>
            <li>
                <ul>
                    <li class="view-list">
                        <a id="view" href="#">Просмотр <span class="material-symbols-outlined">expand_more</span></a>
                        <ul id="list-values" class="header-list">
                            <li><a href="<?php echo BASE_URL . 'events.php' ?>">События</a></li>
                            <li><a href="<?php echo BASE_URL . 'persons.php' ?>">Лица</a></li>
                        </ul>
                    </li>

                </ul>
            </li>
            <li>
                <ul>
                    <li class="view-list">
                        <a id="view-edit" href="#">Ввод данных <span class="material-symbols-outlined">expand_more</span></a>
                        <ul id="list-values-edit" class="header-list">
                           <li><a href="<?php echo BASE_URL . 'add-event.php' ?>">Событие</a></li>
                           <li><a href="<?php echo BASE_URL . 'add-person.php' ?>">Лицо</a></li>
                        </ul>
                    </li>

                </ul>
            </li>
            <li><a href="<?php echo BASE_URL . 'logout.php' ?>">Выйти</a></li>
            <?php endif; ?>
        </ul>
        
    </div>
</div>
</navbar>