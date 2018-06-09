<?php


use yii\helpers\{Html,Url};

?>
<div class="navbar-default sidebar" role="navigation">
                <div class="sidebar-nav navbar-collapse">
                    <ul class="nav" id="side-menu">
                        <li class="sidebar-search">
                            <div class="input-group custom-search-form">
                                <input type="text" class="form-control" placeholder="Search...">
                                <span class="input-group-btn">
                                <button class="btn btn-default" type="button">
                                    <i class="fa fa-search"></i>
                                </button>
                            </span>
                            </div>
                            <!-- /input-group -->
                        </li>
                        <li>
                            <a href="<?php echo Url::to(['/site/index'])?>"><i class="fa fa-dashboard fa-fw"></i> Основной панель</a>
                        </li>
                        <?php 
                            if(\Yii::$app->hasModule("rbac") && \Yii::$app->user->can("superadmin")){
                        ?>
                        <li>
                            <a href="<?php echo Url::to(['/rbac/rbac/index'])?>"><i class="fa fa-sitemap fa-fw"></i> <?php echo Yii::t('site',"RBAC")?></a>
                            <!-- <ul class="nav nav-second-level">
                                <li>
                                    <a href="<?php echo Url::to(['site/index'])?>">Роли</a>
                                </li>
                                <li>
                                    <a href="<?php echo Url::to(['site/index'])?>">Права</a>
                                </li>
                            </ul> -->
                            <!-- /.nav-second-level -->
                        </li>
                        <?php } ?>
                        <?php 
                            if(\Yii::$app->hasModule("users") && \Yii::$app->user->can("superadmin")){
                        ?>
                            <li>
                                <a href="<?php echo Url::to(['/users/manager/index'])?>"><i class="fa fa-table fa-fw"></i> Пользователи</a>
                            </li>
                        <?php } ?>

                        <?php 
                            if(\Yii::$app->user->can("superadmin")){
                        ?>
                            <li>
                                <a href="<?php echo Url::to(['/level/index'])?>"><i class="fa fa-table fa-fw"></i>
                                    <?php echo Yii::t('site',"LEVELS")?>
                                </a>
                            </li>
                        <?php } ?>
                        

                        

                        


                        

                        <!-- 
                        <li>
                            <a href="#"><i class="fa fa-sitemap fa-fw"></i> Multi-Level Dropdown<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a href="#">Second Level Item</a>
                                </li>
                                <li>
                                    <a href="#">Second Level Item</a>
                                </li>
                                <li>
                                    <a href="#">Third Level <span class="fa arrow"></span></a>
                                    <ul class="nav nav-third-level">
                                        <li>
                                            <a href="#">Third Level Item</a>
                                        </li>
                                        <li>
                                            <a href="#">Third Level Item</a>
                                        </li>
                                        <li>
                                            <a href="#">Third Level Item</a>
                                        </li>
                                        <li>
                                            <a href="#">Third Level Item</a>
                                        </li>
                                    </ul>
                                    
                                </li>
                            </ul>
                            
                        </li> -->
                        <!-- <li>
                            <a href="#"><i class="fa fa-files-o fa-fw"></i> Sample Pages<span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li>
                                    <a href="blank.html">Blank Page</a>
                                </li>
                                <li>
                                    <a href="login.html">Login Page</a>
                                </li>
                            </ul>
                            
                        </li> -->
                    </ul>
                </div>
                <!-- /.sidebar-collapse -->
            </div>