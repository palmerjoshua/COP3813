<!-- opening tags and global links -->
<?php require($_SERVER["DOCUMENT_ROOT"]."inc/header.php"); ?>

<!-- custom links -->
<link rel="stylesheet" type="text/css" href="main.css">

<!-- body starts here -->
<?php require($_SERVER["DOCUMENT_ROOT"]."inc/mid.php"); ?>
        

<!-- Contains dialog box for email link -->
<div id="dialog" title="My Email"></div>

<div class="jumbotron">
    <h1>My R&#233sum&#233</h1>            

    <p> <!-- SUBHEADING -->
        Musician. Writer. Developer.
        <a href="#" id="dialogOpener" class="iconLink" title="My Email">
            <span class="glyphicon glyphicon-envelope" aria-hidden="true" title="My Email" id="emailIcon"></span>
        </a>
        <a href="https://github.com/palmerjoshua/COP3813" target="_blank" class="iconLink" title="GitHub">
            <span class="glyphicon glyphicon-link" aria-hidden="true"></span>
        </a>
    </p> <!-- SUBHEADING -->

    <!--Obfuscates my email address...hopefully-->
    <script type="text/javascript" src="../js/egen.js"></script>  
</div><!--JUMBOTRON-->        

<div class="container-fluid">                  
    <div class="row" id="resumeRow">           
        <div class="col-md-1"></div> <!-- SPACER -->

        <div class="col-md-10"><!-- MIDDLE COLUMN -->                 
            <!-- NAV TABS -->
            <ul class="nav nav-tabs nav-justified" role="tablist">
              <li role="presentation" class="active"><a href="#skills" aria-controls="skills" role="tab" data-toggle="tab">Skills</a></li>
              <li role="presentation"><a href="#education" aria-controls="education" role="tab" data-toggle="tab">Education</a></li>
              <li role="presentation"><a href="#work" aria-controls="work" role="tab" data-toggle="tab">Work</a></li>
            </ul> <!-- NAV TABS -->

            <!-- TAB PANES -->
            <div class="tab-content">
                <!-- SKILLS PANE -->
                <div role="tabpanel" class="tab-pane fade in active" id="skills"> 
                    <dl>
                        <dt>Language Proficiency</dt>
                        <dd>- C/C++</dd>
                        <dd>- Python</dd>
                        <dd>- HTML5/CSS/Javascript</dd>

                        <dt>Other Skills</dt>
                        <dd>- Operating Systems: Linux, OS X, Windows</dd>
                        <dd>- IDE: MS Visual Studio, IDLE, Eclipse, Geany</dd>
                        <dd>- Version Control: Git</dd>

                        <dt>Personal Projects</dt>
                        <dd>- (Python) Wrote a program that converts to/from binary, octal, decimal, and hexadecimal numbers and displays the written work for each step.</dd>
                        <dd>- (Python) Wrote a data analysis program using data from reddit.com</dd>                    
                    </dl>            
                </div> <!-- SKILLS PANE -->

                <!-- EDUCATION PANE -->
                <div role="tabpanel" class="tab-pane fade" id="education"> 
                    <dl>
                        <dt>Degrees</dt>
                        <dd>- B.S. in Computer Science, Florida Atlantic University (in progress)</dd>
                        <dd>- A.A. in Philosophy, Broward College (2011 - 2013)</dd>

                        <dt>GPA</dt>
                        <dd>- Cumulative: 3.3</dd>
                        <dd>- CS courses: 3.9</dd>

                        <dt>Relevant Coursework</dt>
                        <dd>- Database Structures</dd>
                        <dd>- Internet Computing</dd>
                        <dd>- Data Structures (C++)</dd>
                        <dd>- Microprocessors</dd>
                        <dd>- Logic Design</dd>           
                    </dl>           
                </div> <!-- EDUCATION PANE -->

                <!-- WORK PANE -->
                <div role="tabpanel" class="tab-pane fade" id="work">
                    <dl>
                        <dt>Freelance Writer</dt>
                        <dd>- BACM Consultants, Inc.</dd>
                        <dd>- November 2012 - February 2013</dd>
                        <dd>- Helped write and plan content for the company's website and newsletters.</dd>

                        <dt>Sales Associate</dt>
                        <dd>- Ghost Armor</dd>
                        <dd>- June 2012 - November 2012</dd>
                        <dd>- Sold cell phone screen/body protectors.</dd>

                        <dt>Guitar and Keyboard Instructor</dt>
                        <dd>- New York Music Academy (Sunrise, FL)</dd>
                        <dd>- February 2006 - August 2009</dd>
                        <dd>- Taught private lessons and large group lessons.</dd>               
                    </dl>           
                </div> <!-- WORK PANE -->                     
            </div> <!-- TAB PANES -->               
        </div> <!-- MIDDLE COLUMN -->

        <div class="col-md-1"></div> <!-- SPACER -->                      
    </div> <!-- ROW -->           
</div> <!-- CONTAINER -->

<!-- closing body and html tags -->
<?php require($_SERVER["DOCUMENT_ROOT"]."inc/footer.php"); ?>