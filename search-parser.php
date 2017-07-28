<?php include('header.php');
//Search Configuration
$per_page = 2; //results shown per page




//sanitize the phrase
$phrase = clean_string( $_GET['the_query']);

//parse the search form if the phrase is not blank
if( $phrase != '' ){
    $query = "SELECT title, date, body, post_id FROM posts WHERE ( title LIKE '%$phrase%' OR body LIKE '%$phrase%' ) AND is_published = 1 ORDER BY date DESC";
    //get all the posts that contain the phrase
    $result = $db->query($query);
    //query result
    $total = $result->num_rows;
    //how many pages are needed for search results
    $max_page = ceil($total / $per_page);
    //find the page that is currently displayed
    //example query string (search.php?phrase=example&page=2)
    if($_GET['page']){
        $current_page = $_GET['page'];
    }else{
        $current_page = 1;
    }
    if($current_page > $max_page){
        $current_page = $max_page;
    }
}
//end search parser
?>

<div class="">
    <main class="content col-sm-8">
        <?php
        //if there are results then show them
        if( $total >= 1 ){
            ?>
            <section class="results">
                <h1>Search Results</h1>
                <h2><?php echo $total; ?> posts found.</h2>
                <h3>Showing page <?php echo $current_page; ?> of <?php echo $max_page; ?></h3>
                <?php
                //find offset for the current page
                $offset = ( $current_page - 1 ) * $per_page;
                $query .= " LIMIT $offset, $per_page";
                //run the query again with a limit
                $result = $db->query($query);
                ?>

                <?php while( $row = $result->fetch_assoc() ){ ?>
                    <article>
                        <h2><a href="single.php?post_id=<?php echo $row['post_id']; ?>">
                                <?php echo $row['title']; ?>
                            </a></h2>
                        <div class="date"><?php echo convert_date($row['date']); ?></div>
                        <div class="excerpt"><?php echo substr($row['body'], 0, 100); ?>&hellip;</div>
                    </article>
                <?php }; ?>
            </section>

            <section class="pagination">
                <?php
                $previous = $current_page -1;
                $next = $current_page +1;
                ?>
                <?php if($current_page != 1){ ?>
                    <a href="search.php?the_query=<?php echo $phrase; ?>&amp;page=<?php echo $previous; ?>">Previous Page</a>
                <?php }
                for($i=1; $i <= $max_page; $i++){
                    ?>
                    <a href="search.php?the_query=<?php echo $phrase; ?>&amp;page=<?php echo $i; ?>">
                        <?php echo $i; ?>
                    </a>
                    <?php
                }
                ?>



                <?php if($current_page != $max_page){ ?>
                    <a href="search.php?the_query=<?php echo $phrase; ?>&amp;page=<?php echo $next; ?>">Next Page</a>
                <?php } ?>
            </section>
        <?php }else{
            echo 'Sorry.  We didn\'t find anything for' . $phrase;
        } ?>
    </main>
</div>
<?php include('sidebar.php'); ?>
<?php include('footer.php'); ?>
