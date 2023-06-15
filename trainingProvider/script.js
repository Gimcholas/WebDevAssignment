counter = 1;
totalAmount = 1;


    
// function getSectionHtml() {
//     console.log("Test");
//     var sectionHtml = document.getElementById("courseSection");
//     console.log(sectionHtml);
//     sectionHtml.innerHTML+=html; 
// }


function addSection() {
    counter+=1;
    totalAmount+=1;

    const sectionDiv = document.createElement("div");
    sectionDiv.id = "courseSection" + counter;

    const html = `<div id="courseSection'+ counter + '">\
    <div class="input-box">\
    <label for="sectionName">Section Name</label> \
    <input type="text" name="sectionName[]" required>\
    </div><br>\
    <div class="input-box">\
    <label for="instructorUsername">Instructor Username</label>\
    <select name="instructorUsername[]" id="cloneSelector" required>\
    </select>\
    </div><br>\
    <div class="input-box">\
    <label for="startTime">Start Time</label>\
    <input type="time" name="startTime[]" required>\
    </div><br>\
    <div class="input-box">\
    <label for="endTime">End Time</label>\
    <input type="time" name="endTime[]" required>\
    </div><br>\
    <div class="input-box">\
    <label for="day">Day</label>\
    <select name="day[]" required>\
        <option value="">Choose a day</option>\
        <option value="Sunday">Sunday</option>\
        <option value="Monday">Monday</option>\
        <option value="Tuesday">Tuesday</option>\
        <option value="Wednesday">Wednesday</option>\
        <option value="Thursday">Thursday</option>\
        <option value="Friday">Friday</option>\
        <option value="Saturday">Saturday</option>\
    </select>\
    </div><br>\
    <div class="input-box">\
        <label for="maxStudentNum">Maximum Student Allowed</label>\
        <input type="number" name="maxStudentNum[]" required>\
    </div><br>\
    `;
    const html2 = ` <input type="button" value="Remove Section" onclick="removeSection(`+counter +`)">\
                    </div>\
                    <hr><br>`;
    
    

    sectionDiv.innerHTML = html + html2;
    var form = document.getElementById("additionalSection");
    //form.innerHTML+=html;
    form.appendChild(sectionDiv);
    var first = document.getElementById("originalSelector");
    var options = first.innerHTML;

    var clone = document.getElementById("cloneSelector");
    clone.innerHTML = options;
};

function removeSection(counter) {
        document.getElementById("courseSection"+ counter).remove();
        totalAmount-=1;
};
