counter = 1;

function addSection() {
    counter+=1;

    const sectionDiv = document.createElement("div");
    sectionDiv.id = "courseSection" + counter;

    const html = `<div id="courseSection'+ counter + '">\
    <div class="input-box">\
    <label for="sectionName">Section Name</label> \
    <input type="text" name="sectionName">\
    </div><br>\
    <div class="input-box">\
    <label for="instructorUsername">Instructor Username</label>\
    <input type="text" name="instructorUsername">\
    </div><br>\
    <div class="input-box">\
    <label for="startTime">Start Time</label>\
    <input type="time" name="startTime">\
    <div><br>\
    <div class="input-box">\
    <label for="endTime">End Time</label>\
    <input type="time" name="endTime">\
    <div><br>\
    <div class="input-box">\
    <label for="day">Day</label>\
    <select name="day">\
        <option value="">Choose a day</option>\
        <option value="Sunday">Sunday</option>\
        <option value="Monday">Monday</option>\
        <option value="Tuesday">Tuesday</option>\
        <option value="Wednesday">Wednesday</option>\
        <option value="Thursday">Thursday</option>\
        <option value="Friday">Friday</option>\
        <option value="Saturday">Saturday</option>\
    </select>\
    <div><br>\
    <div class="input-box">\
        <label for="maxStudentNum">Maximum Student Allowed</label>\
        <input type="number" name="maxStudentNum">\
    </div><br>\
    <input type="button" value="Remove Section" onclick="removeSection(`+counter +`)">\
    </div>\
    <hr><br>`;

    sectionDiv.innerHTML = html;
    var form = document.getElementById("additionalSection");
    //form.innerHTML+=html;
    form.appendChild(sectionDiv);
}

function removeSection(counter) {
        document.getElementById("courseSection"+ counter).remove();
}
