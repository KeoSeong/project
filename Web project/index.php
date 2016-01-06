<?php 
    require_once("base.php");
	include 'index_load.php';
?>

<? startblock('head'); ?>
    <link rel="stylesheet" type="text/css" href="css/index.css" />
<? endblock('head'); ?>


    <article>
        <div>
            <div>새로운 문제
            
                <div>
                <div><ul>
                  <?php
                 try {

                    $LP = new loadProblem();
                    $news=$LP->newproblem();
                  }catch(Exception $e) {
                        //header("Loaction:error.php");
                    }
                foreach($news as $new){                   
                ?>
                
                <li><b>유형:</b><?=$new["type"]?>	| <b>문제:</b><?=$new["problem"]?></li>
                
                <?php } ?>

                </ul></div>
                </div>
            </div>
            <div>어려운 문제
                <div>
                
                <div><ul>
                  <?php
                 try {
                    $LP = new loadProblem();
                    $hards=$LP->hardproblem();
                    }catch(Exception $e) {
                        //header("Loaction:error.php");
                    }
                foreach($hards as $hard){                   
                ?>
                <li><b>유형:</b><?=$hard["type"]?> |	<b>문제:</b><?=$hard["problem"]?> | <b>틀린횟수:</b><?=$hard["count(result)"]?>번</li>
                
                <?php } ?>
                </ul></div>
                
                
                </div>
            </div>
            <div>나의 문제 정보
                <div>
            
            <div><ul>
              <?php
                 try {
                    
                    $LP = new loadProblem();
                    $my=$LP->myproblem();
                    }catch(Exception $e) {
                        //header("Loaction:error.php");
                    }
                foreach($my as $m){                   
                ?>
                <li><b>문제:</b><?=$m["problem"]?>	| <b>결과:</b><?php 
                	if($m["result"]==0){ ?>
                	틀림
                	<?php
                	}
                	?><?php 
                	if($m["result"]==1){ ?>
                	맞음
                	<?php
                	}
                	?>
                	
                </li>
                
                <?php } ?>
            
            </ul></div>
            
            
            </div>
            </div>
        </div>
    </article>
 