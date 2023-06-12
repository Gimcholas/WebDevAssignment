<?php include "../db_connect.php";

?>

<!DOCTYPE html>
<html>
<head> 
    <title>Add Course</title>
    <link rel='stylesheet' type="text/css" href=style.css>
    <script text="text/javascript" src="script.js"></script>
</head> 
<body>
    <form action="test.php" method="post" id="courseForm">
        <div class="input-box">
        <label for="courseName">Course Name</label>
        <input type="text" name="courseName"> 
        </div><br>

        <div class="input-box">
        <label for="startDate">Start Date</label>
        <input type="date" name="startDate"> 
        </div><br>

        <div class="input-box">
        <label for="endDate">End Date</label>
        <input type="date" name="endDate"> 
        </div><br>

        <div class="input-box">
        <label for="courseIntro">Course Introduction</label>
        <input type="text" name="courseIntro"> 
        </div><br>

        <hr><br>
        <div class="courseSection">
            <div class="input-box">
            <label for="sectionName">Section Name</label>
            <input type="text" name="sectionName">
            </div><br>

            <div class="input-box">
            <label for="instructorUsername">Instructor Username</label>
            <input type="text" name="instructorUsername">
            </div><br>

            <div class="input-box">
            <label for="startTime">Start Time</label>
            <input type="time" name="startTime">
            <div><br>

            <div class="input-box">
            <label for="endTime">End Time</label>
            <input type="time" name="endTime">
            <div><br>

            <div class="input-box">
            <label for="day">Day</label>
            <select name="day">
                <option value="">Choose a day</option>
                <option value="Sunday">Sunday</option>
                <option value="Monday">Monday</option>
                <option value="Tuesday">Tuesday</option>
                <option value="Wednesday">Wednesday</option>
                <option value="Thursday">Thursday</option>
                <option value="Friday">Friday</option>
                <option value="Saturday">Saturday</option>
            </select>    
            <div><br>
            <div class="input-box">
                <label for="maxStudentNum">Maximum Student Allowed</label>
                <input type="number" name="maxStudentNum">
            </div><br>
        </div>
        <hr><br>
        
        <div id="additionalSection"></div>
        
        <div class="addSection">
        <input type="button" value="Add More Section" onclick="addSection()">
        </div>

        <div class="submit">
        <input type="submit" value="Create Course">
        </div>
    </form>
</body>
