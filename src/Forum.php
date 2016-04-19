



<?php



/**

*	@file : Feed.php

*	@author : Mike Neises, Travis Augustine, Ethan Ward

*	@date : 2016.04.08

*	@brief: Takes topics from forum database and displays them

*/



	session_start();



	if(isset($_GET['forum'])) {

		$_SESSION['forumname'] = $_GET['forum'];

	}



	class Forum {



		private $query;

		private $mysqli;

		private $user;

		private $forum;



		/**

		*  @name Feed

		*  @pre None

		*  @post Initializes variables and MySQL database

		*  @return none

		*/

		public function Forum() {

			$this->mysqli = new mysqli('mysql.eecs.ku.edu', 'eward', 'ethanward', 'eward');

			$this->user = $_SESSION["username"];

			$this->forum = $_SESSION["forumname"];

			$this->query = "SELECT * FROM EECSPosts WHERE forum_id='$this->forum' AND isTopic=1";

		}



		/**

		*  @name isOK

		*  @pre None

		*  @post Prints error if connection failed

		*  @return none

		*/

		private function isOK() {

			if ($this->mysqli->connect_errno) {

				printf("Connect failed: %s\n", $this->mysqli->connect_error);

				exit();

			}

		}



		public function close() {

			$this->mysqli->close();

		}





		/**

		*  @name display

		*  @pre None

		*  @post Displays posts and navigation

		*  @return none

		*/

		public function display() {

      	//Checks to make sure the mysql database can be accessed

      		$this->isOK();



			echo "<h1>".$this->forum." Feed</h1>";

			if ($result = $this->mysqli->query($this->query))

			{

				/* fetch associative array */



				//Here we display the posts with the related username, which also serves as a link to their profile page.

				echo "<ul>";

				while ($row = $result->fetch_assoc())

				{

					echo "<br>";

					printf ("<a href = 'FeedFrontEnd.html?topic=%s'>%s</a> \n", $row["topic_id"],$row["topic_id"]);

					echo "<br>-";

					printf ("<a href = 'ProfileFrontEnd.html?profile=%s'>%s</a> \n", $row["user_id"],$row["user_id"]);

					echo "<br>";

				}

				echo "</ul>";



				/* free result set */

				$result->free();

			}



		}





	}
