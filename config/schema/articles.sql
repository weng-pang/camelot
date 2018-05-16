-- ===============================================================================
--   This file is automatically generated by the "bin/cake dump_articles" shell.
-- ===============================================================================

-- ----------------------------------------------------------------------
--   Clear existing data in preparation for importing fresh data below.
-- ----------------------------------------------------------------------

DELETE FROM articles_tags WHERE 1;
DELETE FROM article_views WHERE 1;
DELETE FROM articles WHERE 1;
DELETE FROM tags WHERE 1;


-- -----------------------------------------------------------------------------------------
-- Output from "mysqldump --no-create-info articles tags articles_tags articles_views"
-- -----------------------------------------------------------------------------------------

-- MySQL dump 10.16  Distrib 10.1.30-MariaDB, for debian-linux-gnu (x86_64)
--
-- Host: localhost    Database: cms
-- ------------------------------------------------------
-- Server version	10.1.30-MariaDB-0ubuntu0.17.10.1

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Dumping data for table `articles`
--

LOCK TABLES `articles` WRITE;
/*!40000 ALTER TABLE `articles` DISABLE KEYS */;
INSERT INTO `articles` VALUES (1,1,'Welcome to Camelot','welcome','\n<p>Camelot is a custom CMS written using <a href=\"https://cakephp.org\">CakePHP</a>. The idea is to show how various different functionality can be implemented in a modern PHP website using the CakePHP framework. Initially, it is a basic blog site, but over time it will grow as more features are added. The source code can be viewed at <a href=\"https://git.infotech.monash.edu/UGIE/cms\">https://git.infotech.monash.edu/UGIE/cms</a>.</p>\n<p>The intention is that students are able to look at the source code if they are curious abou thow to perform certain tasks. This can then be used as a learning tool to help students implement their own systems.</p>\n<p>If there is any code that doesn\'t make sense, don\'t copy it blindly. Instead, email <a href=\"mailto:peter.serwylo@monash.edu\">peter.serwylo@monash.edu</a> and ask if he can add further clarifying comments to the code base, or perhaps another article in Camelot to further explain the concept.</p>\n',1,'2018-05-15 05:46:08','2018-05-15 05:48:59'),(2,1,'Viewing the source code of Camelot','viewing-source','\n<p>As this website is built to illustrate certain coding practices, it is important to be able to look at the source code. This includes not only the PHP code (Controllers, Models, etc), but also the view code (Views, Layouts). On any page, you should be able to view links to the relevant Controller, Action, View, and Template for that page. This is true both for the public website, and also the administrator dashaboard. In addition to this, the entire source code is available at <a href=\"https://git.infotech.monash.edu/UGIE/cms\">https://git.infotech.monash.edu/UGIE/cms</a>.</p>\n',1,'2018-05-15 05:46:08','2018-05-15 05:50:14'),(3,1,'Logging in to the Admin Dashboard','admin-dashboard','Anyone can log into the administrator dashboard for this website. This site is currently configured to be in \"demo mode\", a mode I invented which allows anyone to log in and play around with the administrator dashboard. To do this, click the \"Login\" button in the top right of any page. As it is in demo mode, it is already prefilled with a username + password that you can use to log in. Any content you add will periodically get deleted as the website database is cleared and reinstalled.',1,'2018-05-15 05:46:08','2018-05-15 05:46:08'),(4,1,'Articles have many tags, tags have many articles','many-to-many','\n<p>ONe of the common patterns seen in many websites is a many-to-many join between two entities. Classic examples include:</p>\n<ul><li>\"Categories have many products, but a product can have many categories\", and</li>\n<li>\"An order has many items, but an item can appear on many different orders\".</li>\n</ul><p>The most obvious way this type of relationship is realised in Camelot is through an <code>Articles &lt;-&gt; Tags</code> relationship. This involves several aspects, described below.</p>\n<h2>Database Model</h2>\n<p>The database model for a many-to-many relationship requires a join table. That is, a table which typically doesn\'t contain much information beyond two foreign keys, one to each of the entities which need to be joined. The join table for this <code>Articles &lt;-&gt; Tags</code> relationship is the most basic:</p>\n<pre style=\"padding-left:30px;\">CREATE TABLE articles_tags (<br />    article_id INT NOT NULL,<br />    tag_id INT NOT NULL,<br />    PRIMARY KEY (article_id, tag_id),<br />    FOREIGN KEY tag_key(tag_id) REFERENCES tags(id),<br />    FOREIGN KEY article_key(article_id) REFERENCES articles(id)<br />);</pre>\n<p>Other times, a join table may require more attributes. Think of the \"Order has many items, item belongs to many orders\" relationship. With that it is common to have a <code>orders_items</code> table which includes not just the two foreign keys, but also things such as \"Quantity\".</p>\n<h2>CakePHP Models</h2>\n<p>Once the <code>articles</code>, <code>tags</code>, and <code>articles_tags</code> tables have been created, we need to ensure that CakePHP is aware of this association. Note that CakePHP does not require a separate Entity + Table class for the <code>articles_tags</code> table. You could have one if you need it (e.g. in the <code>orders_items</code> example above), but this for tagging articles, there is no extra information saved with this association. However, you <a href=\"https://book.cakephp.org/3.0/en/orm/associations.html#belongstomany-associations\">do need to tell the <code>ArticlesTable</code> that it <code>belongsToMany</code> <code>Tags</code></a>, and vice-verca:</p>\n<pre style=\"background-color:#ffffff;color:#000000;font-family:\'DejaVu Sans Mono\';font-size:10.5pt;padding-left:30px;\">class ArticlesTable extends Table {<br />    ...<br />    public function initialize(array $config)<br />    {<br />        parent::initialize($config);<br />        ...<br />        $this-&gt;belongsToMany(\'Tags\');<br />        ...<br />    }<br />    ...<br />}<span style=\"background-color:#f7faff;\"><br /></span></pre>\n<h2>Database Queries</h2>\n<p>Now that the table exists, and the association is correctly setup in our model layer, there are a few more considerations with regards to the data model and how CakePHP interacts with it. Firstly, when loading a list of articles from the database, it acn be helpful to also include information about the tags, so that you can, e.g. loop over <code>$article-&gt;tags</code> and display them to the user. In the case of Camelot, we display a list of associated articles when viewing a tag in the admin dashboard, and so we want to loop over <code>$tag-&gt;articles</code> in the view.</p>\n<p>To do this, <a href=\"https://book.cakephp.org/3.0/en/orm/retrieving-data-and-resultsets.html#eager-loading-associations\">use <code>contains</code> when loading data</a>:</p>\n<pre style=\"padding-left:30px;\">$tag = $this-&gt;Tags-&gt;get($id, [<br />    \'contain\' =&gt; [\'Articles\']<br />]);</pre>\n<h2>Basic User Interface</h2>\n<p>If you use <code>./bin/cake bake</code> to produce a form for articles, you will notice that it includes two interesting parts with regard to the selection of tags.</p>\n<p>Firstly, the controller queries the database to get a list of available tags, and then passes it to the view. This is important, because how else does the view know what tags to offer the user when they edit an article?</p>\n<pre style=\"padding-left:30px;\">$tags = $this-&gt;Articles-&gt;Tags-&gt;find(\'list\');<br />$this-&gt;set(\'tags\', $tags);</pre>\n<p>Secondly, the view adds a multi-select control to the form. This is described further in the CakePHP documentation for \"<a href=\"https://book.cakephp.org/3.0/en/views/helpers/form.html#creating-inputs-for-associated-data\">Creating Inputs for Associated Data</a>\".</p>\n<h2>Improved User Interface</h2>\n<p>The administration user interface needs to allow users to choose many tags when editing an article. The typical way this is done via HTML is with a <code>&lt;select&gt;</code> widget that allows fro muptiple selection. This is what <a href=\"https://book.cakephp.org/3.0/en/views/helpers/form.html#creating-inputs-for-associated-data\">CakePHP outputs by default</a>. However, this UX is particularly terrible for users, because they need to somehow know that you should hold down the Control key while clicking items to select additional items.</p>\n<p>Camelot indeed does use the default CakePHP multiselect, but then it makes it much more usable and interactive by utilising the <a href=\"https://harvesthq.github.io/chosen/\">Chosen</a> JavaScript library.</p>\n<p>The source code for the template doesn\'t do anything special when outputting the multi-select widget:</p>\n<pre style=\"padding-left:30px;\">echo $this-&gt;Form-&gt;control(\'tags._ids\', [\'options\' =&gt; $tags]);</pre>\n<p>Instead, the magic happens at the end of the admin.ctp template, where it does the following:</p>\n<pre style=\"padding-left:30px;\">&lt;?php echo $this-&gt;Html-&gt;script(\'lib/chosen.jquery.min.js\'); ?&gt;<br />&lt;script&gt;<br />(function() {<br />    $(\'select\').chosen({width: \'50%\'});<br />})();<br />&lt;/script&gt;</pre>\n<p>The first line asks the browser to load the required JavaScript file, while the function in the <code>&lt;script&gt;</code> tag says \"Find all \'select\' boxes in the page, and ask the Chosen library to make them pretty\".</p>\n',1,'2018-05-15 05:46:08','2018-05-16 03:16:04'),(5,1,'Fifth Post','fifth-post','This is the fifth post.',1,'2018-05-15 05:46:08','2018-05-15 05:46:08'),(6,1,'Sixth Post','sixth-post','This is the sixth post.',1,'2018-05-15 05:46:08','2018-05-15 05:46:08');
/*!40000 ALTER TABLE `articles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `tags`
--

LOCK TABLES `tags` WRITE;
/*!40000 ALTER TABLE `tags` DISABLE KEYS */;
INSERT INTO `tags` VALUES (1,'Database','2018-05-15 05:49:50','2018-05-15 05:49:50'),(2,'PHP','2018-05-15 05:49:55','2018-05-15 05:49:55'),(3,'HTML','2018-05-15 05:50:00','2018-05-15 05:50:00');
/*!40000 ALTER TABLE `tags` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `articles_tags`
--

LOCK TABLES `articles_tags` WRITE;
/*!40000 ALTER TABLE `articles_tags` DISABLE KEYS */;
INSERT INTO `articles_tags` VALUES (2,2),(2,3),(4,1),(4,2),(4,3);
/*!40000 ALTER TABLE `articles_tags` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping data for table `article_views`
--

LOCK TABLES `article_views` WRITE;
/*!40000 ALTER TABLE `article_views` DISABLE KEYS */;
INSERT INTO `article_views` VALUES (840,1,1,'2018-02-10 04:05:45','2018-05-16 04:05:45'),(841,1,1,'2018-03-27 04:05:45','2018-05-16 04:05:45'),(842,1,1,'2018-02-25 04:05:45','2018-05-16 04:05:45'),(843,1,1,'2018-04-04 04:05:45','2018-05-16 04:05:45'),(844,1,1,'2018-03-03 04:05:45','2018-05-16 04:05:45'),(845,1,1,'2018-05-13 04:05:45','2018-05-16 04:05:45'),(846,1,1,'2018-04-05 04:05:45','2018-05-16 04:05:45'),(847,1,1,'2018-05-16 04:05:45','2018-05-16 04:05:45'),(848,1,1,'2018-02-09 04:05:45','2018-05-16 04:05:45'),(849,1,1,'2018-03-26 04:05:45','2018-05-16 04:05:45'),(850,1,1,'2018-02-25 04:05:45','2018-05-16 04:05:45'),(851,1,1,'2018-05-01 04:05:45','2018-05-16 04:05:45'),(852,1,1,'2018-03-13 04:05:45','2018-05-16 04:05:45'),(853,1,1,'2018-02-13 04:05:45','2018-05-16 04:05:45'),(854,1,1,'2018-03-24 04:05:45','2018-05-16 04:05:45'),(855,1,1,'2018-04-17 04:05:45','2018-05-16 04:05:45'),(856,1,1,'2018-05-08 04:05:45','2018-05-16 04:05:45'),(857,1,1,'2018-05-14 04:05:45','2018-05-16 04:05:45'),(858,1,1,'2018-03-17 04:05:45','2018-05-16 04:05:45'),(859,1,1,'2018-03-08 04:05:45','2018-05-16 04:05:45'),(860,1,1,'2018-04-10 04:05:45','2018-05-16 04:05:45'),(861,1,1,'2018-04-14 04:05:45','2018-05-16 04:05:45'),(862,1,1,'2018-02-08 04:05:45','2018-05-16 04:05:45'),(863,1,1,'2018-02-12 04:05:45','2018-05-16 04:05:45'),(864,1,1,'2018-03-01 04:05:45','2018-05-16 04:05:45'),(865,1,1,'2018-04-25 04:05:45','2018-05-16 04:05:45'),(866,1,1,'2018-03-29 04:05:45','2018-05-16 04:05:45'),(867,1,1,'2018-05-14 04:05:45','2018-05-16 04:05:45'),(868,1,1,'2018-03-02 04:05:45','2018-05-16 04:05:45'),(869,1,1,'2018-03-09 04:05:45','2018-05-16 04:05:45'),(870,1,1,'2018-04-17 04:05:45','2018-05-16 04:05:45'),(871,1,1,'2018-05-09 04:05:45','2018-05-16 04:05:45'),(872,1,1,'2018-05-02 04:05:45','2018-05-16 04:05:45'),(873,1,1,'2018-04-26 04:05:45','2018-05-16 04:05:45'),(874,1,1,'2018-03-10 04:05:45','2018-05-16 04:05:45'),(875,1,1,'2018-02-19 04:05:45','2018-05-16 04:05:45'),(876,1,1,'2018-02-22 04:05:45','2018-05-16 04:05:45'),(877,1,2,'2018-04-30 04:05:45','2018-05-16 04:05:45'),(878,1,2,'2018-03-03 04:05:45','2018-05-16 04:05:45'),(879,1,2,'2018-04-27 04:05:45','2018-05-16 04:05:45'),(880,1,2,'2018-05-07 04:05:45','2018-05-16 04:05:45'),(881,1,2,'2018-02-27 04:05:45','2018-05-16 04:05:45'),(882,1,2,'2018-02-14 04:05:45','2018-05-16 04:05:45'),(883,1,2,'2018-03-22 04:05:45','2018-05-16 04:05:45'),(884,1,2,'2018-05-07 04:05:45','2018-05-16 04:05:45'),(885,1,2,'2018-04-10 04:05:45','2018-05-16 04:05:45'),(886,1,2,'2018-02-06 04:05:45','2018-05-16 04:05:45'),(887,1,2,'2018-04-20 04:05:45','2018-05-16 04:05:45'),(888,1,2,'2018-05-14 04:05:45','2018-05-16 04:05:45'),(889,1,2,'2018-02-17 04:05:45','2018-05-16 04:05:45'),(890,1,2,'2018-04-01 04:05:45','2018-05-16 04:05:45'),(891,1,2,'2018-03-28 04:05:45','2018-05-16 04:05:45'),(892,1,2,'2018-04-30 04:05:45','2018-05-16 04:05:45'),(893,1,2,'2018-04-07 04:05:45','2018-05-16 04:05:45'),(894,1,2,'2018-02-24 04:05:45','2018-05-16 04:05:45'),(895,1,2,'2018-02-06 04:05:45','2018-05-16 04:05:45'),(896,1,2,'2018-03-31 04:05:45','2018-05-16 04:05:45'),(897,1,2,'2018-05-11 04:05:45','2018-05-16 04:05:45'),(898,1,2,'2018-04-29 04:05:45','2018-05-16 04:05:45'),(899,1,2,'2018-03-20 04:05:45','2018-05-16 04:05:45'),(900,1,2,'2018-03-26 04:05:45','2018-05-16 04:05:45'),(901,1,2,'2018-04-29 04:05:45','2018-05-16 04:05:45'),(902,1,2,'2018-02-06 04:05:45','2018-05-16 04:05:45'),(903,1,2,'2018-04-29 04:05:45','2018-05-16 04:05:45'),(904,1,2,'2018-05-08 04:05:45','2018-05-16 04:05:45'),(905,1,2,'2018-05-12 04:05:45','2018-05-16 04:05:45'),(906,1,2,'2018-04-25 04:05:45','2018-05-16 04:05:45'),(907,1,2,'2018-03-23 04:05:45','2018-05-16 04:05:45'),(908,1,2,'2018-05-14 04:05:45','2018-05-16 04:05:45'),(909,1,2,'2018-05-07 04:05:45','2018-05-16 04:05:45'),(910,1,2,'2018-03-04 04:05:45','2018-05-16 04:05:45'),(911,1,2,'2018-03-29 04:05:45','2018-05-16 04:05:45'),(912,1,2,'2018-02-17 04:05:45','2018-05-16 04:05:45'),(913,1,2,'2018-05-04 04:05:45','2018-05-16 04:05:45'),(914,1,2,'2018-05-12 04:05:45','2018-05-16 04:05:45'),(915,1,2,'2018-04-08 04:05:45','2018-05-16 04:05:45'),(916,1,2,'2018-04-14 04:05:45','2018-05-16 04:05:45'),(917,1,2,'2018-04-19 04:05:45','2018-05-16 04:05:45'),(918,1,2,'2018-05-07 04:05:45','2018-05-16 04:05:45'),(919,1,2,'2018-03-23 04:05:45','2018-05-16 04:05:45'),(920,1,2,'2018-03-20 04:05:45','2018-05-16 04:05:45'),(921,1,2,'2018-05-06 04:05:45','2018-05-16 04:05:45'),(922,1,2,'2018-02-13 04:05:45','2018-05-16 04:05:45'),(923,1,2,'2018-03-16 04:05:45','2018-05-16 04:05:45'),(924,1,2,'2018-04-29 04:05:45','2018-05-16 04:05:45'),(925,1,2,'2018-03-12 04:05:45','2018-05-16 04:05:45'),(926,1,2,'2018-03-27 04:05:45','2018-05-16 04:05:45'),(927,1,2,'2018-04-28 04:05:45','2018-05-16 04:05:45'),(928,1,2,'2018-04-14 04:05:45','2018-05-16 04:05:45'),(929,1,2,'2018-03-19 04:05:45','2018-05-16 04:05:45'),(930,1,2,'2018-02-25 04:05:45','2018-05-16 04:05:45'),(931,1,2,'2018-05-16 04:05:45','2018-05-16 04:05:45'),(932,1,2,'2018-04-17 04:05:45','2018-05-16 04:05:45'),(933,1,2,'2018-04-22 04:05:45','2018-05-16 04:05:45'),(934,1,2,'2018-03-20 04:05:45','2018-05-16 04:05:45'),(935,1,2,'2018-04-08 04:05:45','2018-05-16 04:05:45'),(936,1,2,'2018-02-24 04:05:45','2018-05-16 04:05:45'),(937,1,2,'2018-03-05 04:05:45','2018-05-16 04:05:45'),(938,1,2,'2018-03-11 04:05:45','2018-05-16 04:05:45'),(939,1,2,'2018-03-14 04:05:45','2018-05-16 04:05:45'),(940,1,2,'2018-03-16 04:05:45','2018-05-16 04:05:45'),(941,1,2,'2018-05-01 04:05:45','2018-05-16 04:05:45'),(942,1,2,'2018-04-10 04:05:45','2018-05-16 04:05:45'),(943,1,2,'2018-05-13 04:05:45','2018-05-16 04:05:45'),(944,1,2,'2018-05-13 04:05:45','2018-05-16 04:05:45'),(945,1,2,'2018-02-20 04:05:45','2018-05-16 04:05:45'),(946,1,2,'2018-03-07 04:05:45','2018-05-16 04:05:45'),(947,1,2,'2018-02-22 04:05:45','2018-05-16 04:05:45'),(948,1,3,'2018-03-07 04:05:45','2018-05-16 04:05:45'),(949,1,3,'2018-03-30 04:05:45','2018-05-16 04:05:45'),(950,1,3,'2018-04-27 04:05:45','2018-05-16 04:05:45'),(951,1,3,'2018-02-22 04:05:45','2018-05-16 04:05:45'),(952,1,3,'2018-05-15 04:05:45','2018-05-16 04:05:45'),(953,1,3,'2018-02-27 04:05:45','2018-05-16 04:05:45'),(954,1,3,'2018-02-09 04:05:45','2018-05-16 04:05:45'),(955,1,3,'2018-03-16 04:05:45','2018-05-16 04:05:45'),(956,1,3,'2018-04-10 04:05:45','2018-05-16 04:05:45'),(957,1,3,'2018-04-25 04:05:45','2018-05-16 04:05:45'),(958,1,3,'2018-03-14 04:05:45','2018-05-16 04:05:45'),(959,1,3,'2018-03-11 04:05:45','2018-05-16 04:05:45'),(960,1,3,'2018-03-02 04:05:45','2018-05-16 04:05:45'),(961,1,3,'2018-04-03 04:05:45','2018-05-16 04:05:45'),(962,1,3,'2018-05-01 04:05:45','2018-05-16 04:05:45'),(963,1,3,'2018-05-12 04:05:45','2018-05-16 04:05:45'),(964,1,3,'2018-04-18 04:05:45','2018-05-16 04:05:45'),(965,1,3,'2018-03-11 04:05:45','2018-05-16 04:05:45'),(966,1,3,'2018-03-31 04:05:45','2018-05-16 04:05:45'),(967,1,3,'2018-02-17 04:05:45','2018-05-16 04:05:45'),(968,1,3,'2018-04-03 04:05:45','2018-05-16 04:05:45'),(969,1,3,'2018-03-05 04:05:45','2018-05-16 04:05:45'),(970,1,3,'2018-05-09 04:05:45','2018-05-16 04:05:45'),(971,1,3,'2018-03-03 04:05:45','2018-05-16 04:05:45'),(972,1,3,'2018-03-26 04:05:45','2018-05-16 04:05:45'),(973,1,3,'2018-02-13 04:05:45','2018-05-16 04:05:45'),(974,1,3,'2018-02-10 04:05:45','2018-05-16 04:05:45'),(975,1,3,'2018-04-07 04:05:45','2018-05-16 04:05:45'),(976,1,3,'2018-03-18 04:05:45','2018-05-16 04:05:45'),(977,1,3,'2018-05-08 04:05:45','2018-05-16 04:05:45'),(978,1,3,'2018-04-19 04:05:45','2018-05-16 04:05:45'),(979,1,3,'2018-03-23 04:05:45','2018-05-16 04:05:45'),(980,1,3,'2018-02-21 04:05:45','2018-05-16 04:05:45'),(981,1,3,'2018-02-07 04:05:45','2018-05-16 04:05:45'),(982,1,3,'2018-03-09 04:05:45','2018-05-16 04:05:45'),(983,1,3,'2018-02-19 04:05:45','2018-05-16 04:05:45'),(984,1,3,'2018-04-27 04:05:45','2018-05-16 04:05:45'),(985,1,3,'2018-02-11 04:05:45','2018-05-16 04:05:45'),(986,1,3,'2018-04-27 04:05:45','2018-05-16 04:05:45'),(987,1,3,'2018-04-15 04:05:45','2018-05-16 04:05:45'),(988,1,3,'2018-02-27 04:05:45','2018-05-16 04:05:45'),(989,1,3,'2018-04-10 04:05:45','2018-05-16 04:05:45'),(990,1,3,'2018-04-02 04:05:45','2018-05-16 04:05:45'),(991,1,3,'2018-03-18 04:05:45','2018-05-16 04:05:45'),(992,1,3,'2018-03-15 04:05:45','2018-05-16 04:05:45'),(993,1,3,'2018-03-05 04:05:45','2018-05-16 04:05:45'),(994,1,3,'2018-02-17 04:05:45','2018-05-16 04:05:45'),(995,1,3,'2018-02-20 04:05:45','2018-05-16 04:05:45'),(996,1,3,'2018-02-11 04:05:45','2018-05-16 04:05:45'),(997,1,3,'2018-04-09 04:05:45','2018-05-16 04:05:45'),(998,1,3,'2018-04-24 04:05:45','2018-05-16 04:05:45'),(999,1,3,'2018-03-14 04:05:45','2018-05-16 04:05:45'),(1000,1,3,'2018-04-26 04:05:45','2018-05-16 04:05:45'),(1001,1,3,'2018-05-11 04:05:45','2018-05-16 04:05:45'),(1002,1,3,'2018-02-07 04:05:45','2018-05-16 04:05:45'),(1003,1,3,'2018-03-21 04:05:45','2018-05-16 04:05:45'),(1004,1,3,'2018-05-15 04:05:45','2018-05-16 04:05:45'),(1005,1,3,'2018-02-13 04:05:45','2018-05-16 04:05:45'),(1006,1,3,'2018-05-09 04:05:45','2018-05-16 04:05:45'),(1007,1,3,'2018-03-19 04:05:45','2018-05-16 04:05:45'),(1008,1,3,'2018-02-27 04:05:45','2018-05-16 04:05:45'),(1009,1,3,'2018-04-12 04:05:45','2018-05-16 04:05:45'),(1010,1,3,'2018-02-08 04:05:45','2018-05-16 04:05:45'),(1011,1,3,'2018-02-07 04:05:45','2018-05-16 04:05:45'),(1012,1,3,'2018-04-14 04:05:45','2018-05-16 04:05:45'),(1013,1,3,'2018-03-19 04:05:45','2018-05-16 04:05:45'),(1014,1,3,'2018-02-07 04:05:45','2018-05-16 04:05:45'),(1015,1,3,'2018-05-05 04:05:45','2018-05-16 04:05:45'),(1016,1,3,'2018-04-13 04:05:45','2018-05-16 04:05:45'),(1017,1,3,'2018-03-25 04:05:45','2018-05-16 04:05:45'),(1018,1,3,'2018-04-16 04:05:45','2018-05-16 04:05:45'),(1019,1,3,'2018-04-03 04:05:45','2018-05-16 04:05:45'),(1020,1,3,'2018-02-21 04:05:45','2018-05-16 04:05:45'),(1021,1,3,'2018-02-16 04:05:45','2018-05-16 04:05:45'),(1022,1,3,'2018-02-13 04:05:45','2018-05-16 04:05:45'),(1023,1,3,'2018-02-05 04:05:45','2018-05-16 04:05:45'),(1024,1,3,'2018-03-24 04:05:45','2018-05-16 04:05:45'),(1025,1,4,'2018-05-01 04:05:45','2018-05-16 04:05:45'),(1026,1,4,'2018-05-11 04:05:45','2018-05-16 04:05:45'),(1027,1,4,'2018-03-10 04:05:45','2018-05-16 04:05:45'),(1028,1,4,'2018-05-03 04:05:45','2018-05-16 04:05:45'),(1029,1,4,'2018-04-13 04:05:45','2018-05-16 04:05:45'),(1030,1,4,'2018-02-27 04:05:45','2018-05-16 04:05:45'),(1031,1,4,'2018-02-16 04:05:45','2018-05-16 04:05:45'),(1032,1,4,'2018-02-13 04:05:45','2018-05-16 04:05:45'),(1033,1,4,'2018-03-20 04:05:45','2018-05-16 04:05:45'),(1034,1,4,'2018-03-13 04:05:45','2018-05-16 04:05:45'),(1035,1,4,'2018-03-07 04:05:45','2018-05-16 04:05:45'),(1036,1,4,'2018-03-17 04:05:45','2018-05-16 04:05:45'),(1037,1,4,'2018-05-01 04:05:45','2018-05-16 04:05:45'),(1038,1,4,'2018-05-16 04:05:45','2018-05-16 04:05:45'),(1039,1,4,'2018-05-02 04:05:45','2018-05-16 04:05:45'),(1040,1,4,'2018-04-27 04:05:45','2018-05-16 04:05:45'),(1041,1,4,'2018-04-03 04:05:45','2018-05-16 04:05:45'),(1042,1,4,'2018-03-22 04:05:45','2018-05-16 04:05:45'),(1043,1,4,'2018-03-25 04:05:45','2018-05-16 04:05:45'),(1044,1,4,'2018-02-10 04:05:45','2018-05-16 04:05:45'),(1045,1,4,'2018-03-11 04:05:45','2018-05-16 04:05:45'),(1046,1,4,'2018-03-23 04:05:45','2018-05-16 04:05:45'),(1047,1,4,'2018-03-15 04:05:45','2018-05-16 04:05:45'),(1048,1,4,'2018-02-08 04:05:45','2018-05-16 04:05:45'),(1049,1,4,'2018-03-18 04:05:45','2018-05-16 04:05:45'),(1050,1,4,'2018-05-12 04:05:45','2018-05-16 04:05:45'),(1051,1,4,'2018-03-18 04:05:45','2018-05-16 04:05:45'),(1052,1,4,'2018-04-20 04:05:45','2018-05-16 04:05:45'),(1053,1,4,'2018-03-31 04:05:45','2018-05-16 04:05:45'),(1054,1,4,'2018-04-26 04:05:45','2018-05-16 04:05:45'),(1055,1,4,'2018-04-22 04:05:45','2018-05-16 04:05:45'),(1056,1,4,'2018-04-12 04:05:45','2018-05-16 04:05:45'),(1057,1,4,'2018-03-04 04:05:45','2018-05-16 04:05:45'),(1058,1,4,'2018-02-18 04:05:45','2018-05-16 04:05:45'),(1059,1,4,'2018-02-06 04:05:45','2018-05-16 04:05:45'),(1060,1,4,'2018-04-23 04:05:45','2018-05-16 04:05:45'),(1061,1,4,'2018-02-16 04:05:45','2018-05-16 04:05:45'),(1062,1,4,'2018-03-08 04:05:45','2018-05-16 04:05:45'),(1063,1,4,'2018-04-29 04:05:45','2018-05-16 04:05:45'),(1064,1,4,'2018-04-04 04:05:45','2018-05-16 04:05:45'),(1065,1,4,'2018-05-09 04:05:45','2018-05-16 04:05:45'),(1066,1,4,'2018-04-03 04:05:45','2018-05-16 04:05:45'),(1067,1,4,'2018-04-15 04:05:45','2018-05-16 04:05:45'),(1068,1,4,'2018-03-22 04:05:45','2018-05-16 04:05:45'),(1069,1,4,'2018-03-18 04:05:45','2018-05-16 04:05:45'),(1070,1,4,'2018-05-15 04:05:45','2018-05-16 04:05:45'),(1071,1,4,'2018-03-07 04:05:45','2018-05-16 04:05:45'),(1072,1,4,'2018-03-02 04:05:45','2018-05-16 04:05:45'),(1073,1,4,'2018-02-12 04:05:45','2018-05-16 04:05:45'),(1074,1,4,'2018-05-01 04:05:45','2018-05-16 04:05:46'),(1075,1,4,'2018-02-25 04:05:45','2018-05-16 04:05:46'),(1076,1,4,'2018-03-30 04:05:45','2018-05-16 04:05:46'),(1077,1,4,'2018-04-24 04:05:45','2018-05-16 04:05:46'),(1078,1,4,'2018-04-13 04:05:45','2018-05-16 04:05:46'),(1079,1,4,'2018-02-28 04:05:45','2018-05-16 04:05:46'),(1080,1,4,'2018-02-24 04:05:45','2018-05-16 04:05:46'),(1081,1,4,'2018-03-28 04:05:45','2018-05-16 04:05:46'),(1082,1,4,'2018-02-18 04:05:45','2018-05-16 04:05:46'),(1083,1,4,'2018-04-12 04:05:45','2018-05-16 04:05:46'),(1084,1,4,'2018-04-10 04:05:45','2018-05-16 04:05:46'),(1085,1,4,'2018-05-08 04:05:45','2018-05-16 04:05:46'),(1086,1,4,'2018-04-15 04:05:45','2018-05-16 04:05:46'),(1087,1,4,'2018-02-12 04:05:45','2018-05-16 04:05:46'),(1088,1,4,'2018-03-20 04:05:45','2018-05-16 04:05:46'),(1089,1,4,'2018-05-15 04:05:45','2018-05-16 04:05:46'),(1090,1,4,'2018-03-26 04:05:45','2018-05-16 04:05:46'),(1091,1,4,'2018-03-21 04:05:45','2018-05-16 04:05:46'),(1092,1,4,'2018-05-02 04:05:45','2018-05-16 04:05:46'),(1093,1,4,'2018-05-01 04:05:45','2018-05-16 04:05:46'),(1094,1,4,'2018-02-22 04:05:45','2018-05-16 04:05:46'),(1095,1,4,'2018-02-08 04:05:45','2018-05-16 04:05:46'),(1096,1,4,'2018-02-22 04:05:45','2018-05-16 04:05:46'),(1097,1,4,'2018-03-31 04:05:45','2018-05-16 04:05:46'),(1098,1,4,'2018-02-23 04:05:45','2018-05-16 04:05:46'),(1099,1,4,'2018-02-07 04:05:45','2018-05-16 04:05:46'),(1100,1,4,'2018-04-14 04:05:45','2018-05-16 04:05:46'),(1101,1,4,'2018-02-20 04:05:45','2018-05-16 04:05:46'),(1102,1,4,'2018-04-20 04:05:45','2018-05-16 04:05:46'),(1103,1,4,'2018-04-09 04:05:45','2018-05-16 04:05:46'),(1104,1,4,'2018-04-17 04:05:45','2018-05-16 04:05:46'),(1105,1,4,'2018-02-26 04:05:45','2018-05-16 04:05:46'),(1106,1,4,'2018-03-08 04:05:45','2018-05-16 04:05:46'),(1107,1,4,'2018-03-22 04:05:45','2018-05-16 04:05:46'),(1108,1,4,'2018-02-24 04:05:45','2018-05-16 04:05:46'),(1109,1,5,'2018-03-07 04:05:45','2018-05-16 04:05:46'),(1110,1,5,'2018-03-27 04:05:45','2018-05-16 04:05:46'),(1111,1,5,'2018-04-01 04:05:45','2018-05-16 04:05:46'),(1112,1,5,'2018-05-09 04:05:45','2018-05-16 04:05:46'),(1113,1,5,'2018-03-22 04:05:45','2018-05-16 04:05:46'),(1114,1,5,'2018-05-06 04:05:45','2018-05-16 04:05:46'),(1115,1,5,'2018-04-11 04:05:45','2018-05-16 04:05:46'),(1116,1,5,'2018-04-30 04:05:45','2018-05-16 04:05:46'),(1117,1,5,'2018-03-30 04:05:45','2018-05-16 04:05:46'),(1118,1,5,'2018-03-19 04:05:45','2018-05-16 04:05:46'),(1119,1,5,'2018-02-12 04:05:45','2018-05-16 04:05:46'),(1120,1,5,'2018-04-25 04:05:45','2018-05-16 04:05:46'),(1121,1,5,'2018-04-01 04:05:45','2018-05-16 04:05:46'),(1122,1,5,'2018-02-10 04:05:45','2018-05-16 04:05:46'),(1123,1,5,'2018-03-23 04:05:45','2018-05-16 04:05:46'),(1124,1,5,'2018-04-27 04:05:45','2018-05-16 04:05:46'),(1125,1,5,'2018-02-17 04:05:45','2018-05-16 04:05:46'),(1126,1,5,'2018-05-10 04:05:45','2018-05-16 04:05:46'),(1127,1,5,'2018-05-03 04:05:45','2018-05-16 04:05:46'),(1128,1,5,'2018-02-10 04:05:45','2018-05-16 04:05:46'),(1129,1,5,'2018-03-14 04:05:45','2018-05-16 04:05:46'),(1130,1,5,'2018-04-06 04:05:45','2018-05-16 04:05:46'),(1131,1,5,'2018-04-15 04:05:45','2018-05-16 04:05:46'),(1132,1,5,'2018-04-09 04:05:45','2018-05-16 04:05:46'),(1133,1,5,'2018-02-13 04:05:45','2018-05-16 04:05:46'),(1134,1,5,'2018-03-11 04:05:45','2018-05-16 04:05:46'),(1135,1,5,'2018-02-15 04:05:45','2018-05-16 04:05:46'),(1136,1,5,'2018-02-12 04:05:45','2018-05-16 04:05:46'),(1137,1,5,'2018-03-08 04:05:45','2018-05-16 04:05:46'),(1138,1,5,'2018-03-14 04:05:45','2018-05-16 04:05:46'),(1139,1,5,'2018-03-02 04:05:45','2018-05-16 04:05:46'),(1140,1,5,'2018-04-11 04:05:45','2018-05-16 04:05:46'),(1141,1,5,'2018-02-10 04:05:45','2018-05-16 04:05:46'),(1142,1,5,'2018-03-17 04:05:45','2018-05-16 04:05:46'),(1143,1,5,'2018-03-06 04:05:45','2018-05-16 04:05:46'),(1144,1,5,'2018-04-24 04:05:45','2018-05-16 04:05:46'),(1145,1,5,'2018-02-15 04:05:45','2018-05-16 04:05:46'),(1146,1,5,'2018-03-18 04:05:45','2018-05-16 04:05:46'),(1147,1,5,'2018-04-28 04:05:45','2018-05-16 04:05:46'),(1148,1,5,'2018-04-02 04:05:45','2018-05-16 04:05:46'),(1149,1,5,'2018-02-20 04:05:45','2018-05-16 04:05:46'),(1150,1,5,'2018-03-20 04:05:45','2018-05-16 04:05:46'),(1151,1,5,'2018-04-13 04:05:45','2018-05-16 04:05:46'),(1152,1,5,'2018-03-02 04:05:45','2018-05-16 04:05:46'),(1153,1,5,'2018-04-16 04:05:45','2018-05-16 04:05:46'),(1154,1,5,'2018-03-14 04:05:45','2018-05-16 04:05:46'),(1155,1,5,'2018-02-23 04:05:45','2018-05-16 04:05:46'),(1156,1,5,'2018-03-17 04:05:45','2018-05-16 04:05:46'),(1157,1,5,'2018-04-04 04:05:45','2018-05-16 04:05:46'),(1158,1,5,'2018-05-15 04:05:45','2018-05-16 04:05:46'),(1159,1,5,'2018-04-11 04:05:45','2018-05-16 04:05:46'),(1160,1,5,'2018-05-12 04:05:45','2018-05-16 04:05:46'),(1161,1,5,'2018-04-29 04:05:45','2018-05-16 04:05:46'),(1162,1,5,'2018-04-16 04:05:45','2018-05-16 04:05:46'),(1163,1,5,'2018-04-22 04:05:45','2018-05-16 04:05:46'),(1164,1,5,'2018-03-27 04:05:45','2018-05-16 04:05:46'),(1165,1,5,'2018-04-19 04:05:45','2018-05-16 04:05:46'),(1166,1,5,'2018-02-13 04:05:45','2018-05-16 04:05:46'),(1167,1,5,'2018-05-15 04:05:45','2018-05-16 04:05:46'),(1168,1,5,'2018-04-04 04:05:45','2018-05-16 04:05:46'),(1169,1,5,'2018-05-07 04:05:45','2018-05-16 04:05:46'),(1170,1,5,'2018-03-24 04:05:45','2018-05-16 04:05:46'),(1171,1,5,'2018-05-07 04:05:45','2018-05-16 04:05:46'),(1172,1,5,'2018-03-15 04:05:45','2018-05-16 04:05:46'),(1173,1,5,'2018-02-20 04:05:45','2018-05-16 04:05:46'),(1174,1,5,'2018-03-16 04:05:45','2018-05-16 04:05:46'),(1175,1,5,'2018-03-27 04:05:45','2018-05-16 04:05:46'),(1176,1,5,'2018-02-05 04:05:45','2018-05-16 04:05:46'),(1177,1,5,'2018-02-10 04:05:45','2018-05-16 04:05:46'),(1178,1,5,'2018-03-21 04:05:45','2018-05-16 04:05:46'),(1179,1,5,'2018-02-09 04:05:45','2018-05-16 04:05:46'),(1180,1,5,'2018-05-12 04:05:45','2018-05-16 04:05:46'),(1181,1,5,'2018-03-24 04:05:45','2018-05-16 04:05:46'),(1182,1,5,'2018-03-18 04:05:45','2018-05-16 04:05:46'),(1183,1,5,'2018-05-11 04:05:45','2018-05-16 04:05:46'),(1184,1,5,'2018-04-02 04:05:45','2018-05-16 04:05:46'),(1185,1,5,'2018-02-27 04:05:45','2018-05-16 04:05:46'),(1186,1,5,'2018-04-10 04:05:45','2018-05-16 04:05:46'),(1187,1,5,'2018-02-12 04:05:45','2018-05-16 04:05:46'),(1188,1,5,'2018-05-06 04:05:45','2018-05-16 04:05:46'),(1189,1,5,'2018-04-28 04:05:45','2018-05-16 04:05:46'),(1190,1,5,'2018-03-08 04:05:45','2018-05-16 04:05:46'),(1191,1,5,'2018-03-24 04:05:45','2018-05-16 04:05:46'),(1192,1,5,'2018-04-14 04:05:45','2018-05-16 04:05:46'),(1193,1,5,'2018-02-05 04:05:45','2018-05-16 04:05:46'),(1194,1,5,'2018-02-18 04:05:45','2018-05-16 04:05:46'),(1195,1,5,'2018-04-04 04:05:45','2018-05-16 04:05:46'),(1196,1,5,'2018-05-10 04:05:45','2018-05-16 04:05:46'),(1197,1,5,'2018-04-10 04:05:45','2018-05-16 04:05:46'),(1198,1,5,'2018-04-09 04:05:45','2018-05-16 04:05:46'),(1199,1,6,'2018-03-04 04:05:45','2018-05-16 04:05:46'),(1200,1,6,'2018-04-03 04:05:45','2018-05-16 04:05:46'),(1201,1,6,'2018-02-17 04:05:45','2018-05-16 04:05:46'),(1202,1,6,'2018-02-20 04:05:45','2018-05-16 04:05:46'),(1203,1,6,'2018-03-01 04:05:45','2018-05-16 04:05:46'),(1204,1,6,'2018-02-13 04:05:45','2018-05-16 04:05:46'),(1205,1,6,'2018-02-06 04:05:45','2018-05-16 04:05:46'),(1206,1,6,'2018-04-12 04:05:45','2018-05-16 04:05:46'),(1207,1,6,'2018-02-20 04:05:45','2018-05-16 04:05:46'),(1208,1,6,'2018-05-07 04:05:45','2018-05-16 04:05:46'),(1209,1,6,'2018-04-03 04:05:45','2018-05-16 04:05:46'),(1210,1,6,'2018-03-04 04:05:45','2018-05-16 04:05:46'),(1211,1,6,'2018-05-08 04:05:45','2018-05-16 04:05:46'),(1212,1,6,'2018-02-20 04:05:45','2018-05-16 04:05:46'),(1213,1,6,'2018-03-17 04:05:45','2018-05-16 04:05:46'),(1214,1,6,'2018-04-02 04:05:45','2018-05-16 04:05:46'),(1215,1,6,'2018-03-13 04:05:45','2018-05-16 04:05:46'),(1216,1,6,'2018-04-26 04:05:45','2018-05-16 04:05:46'),(1217,1,6,'2018-04-06 04:05:45','2018-05-16 04:05:46'),(1218,1,6,'2018-02-26 04:05:45','2018-05-16 04:05:46'),(1219,1,6,'2018-04-13 04:05:45','2018-05-16 04:05:46'),(1220,1,6,'2018-02-17 04:05:45','2018-05-16 04:05:46'),(1221,1,6,'2018-04-18 04:05:45','2018-05-16 04:05:46'),(1222,1,6,'2018-04-20 04:05:45','2018-05-16 04:05:46');
/*!40000 ALTER TABLE `article_views` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2018-05-16 14:06:31