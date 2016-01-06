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
                
                <li>유형:<?=$new["type"]?>	문제:<?=$new["problem"]?></li>
                
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
                <li>유형:<?=$hard["type"]?>	문제:<?=$hard["problem"]?> 틀린횟수:<?=$hard["count(result)"]?> </li>
                
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
                <li>문제:<?=$m["problem"]?>	결과:<?php 
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
        
    <footer>
        <div>
            <div>개발자</p><img src="img/face1.png"><p>김태성</p></div>
            <div>개발자</p><img src="img/face2.jpeg"><p>김민규</p></div>
            <div>개발자</p><img src="img/face2.jpeg"><p>박거성</p></div>
            <div>개발자</p><img src="img/face2.jpeg"><p>안정기</p></div>
            <div>개발자</p><img src="img/face2.jpeg"><p>최준태</p></div>
        </div>
    </footer>