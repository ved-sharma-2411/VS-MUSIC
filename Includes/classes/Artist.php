<?php 
class Artist 
{
    private $con;
    private $id;
    private $name;

    public function __construct($con, $id) {
        $this->con = $con;
        $this->id = $id;

        // ✅ Fetch artist details safely
        $artistQuery = mysqli_query($this->con, "SELECT name FROM artists WHERE id = '$this->id'");
        if(mysqli_num_rows($artistQuery) > 0) {
            $artist = mysqli_fetch_array($artistQuery);
            $this->name = $artist['name'];
        } else {
            $this->name = "Unknown Artist"; // ✅ Fallback if artist ID is invalid
        }
    }

    public function getId() {
        return $this->id;
    }
    
    public function getName() {
        return $this->name; // ✅ Avoids redundant queries
    }

    public function getSongIds() {
        $query = mysqli_query($this->con, "SELECT id FROM songs WHERE artist = '$this->id' ORDER BY plays DESC");

        $array = array();
        while ($row = mysqli_fetch_array($query)) {
            array_push($array, $row['id']);
        }

        return $array; // ✅ Returns an empty array if no songs exist (prevents errors)
    }
}
?>
