function autoExpand(e){
    e.style.height = '2 rem';
    e.style.height = (e.scrollHeight) + "px";
}
const toggleDetail = document.getElementById("toggleDetail");
const toggleStudentList = document.getElementById("toggleStudentList");
const hiddenStudentList = document.getElementById("hiddenStudentList");
const hiddenAnnouncement = document.getElementById("hiddenAnnouncement");
const courseDetail = document.getElementById("hiddenDetail");
const newAnnouncementInput = document.getElementById("newAnnouncementInput");
const hiddenAttributeNewAnnouncement = document.querySelectorAll(".hiddenAttributeNewAnnouncement");
const cancelAnnouncementButton = document.getElementById("cancelAnnouncement");
const newAnnouncementForm = document.getElementById("newAnnouncementForm");

const toggleUpdateSection = document.getElementById("toggleUpdateSection");
const hiddenUpdateSection = document.getElementById("hiddenUpdateSection");

const toggleFeedback = document.getElementById("toggleFeedback");
const hiddenFeedback = document.getElementById("hiddenFeedback");
const toggleCertificate = document.getElementById("toggleCertificate");
const hiddenCertificate = document.getElementById("hiddenCertificate");
const togglePrintCertificate = document.getElementById("printCertificate");
const divShowingCertificate = document.querySelector(".divShowingCertificate");

togglePrintCertificate.addEventListener("click",function(e){
    var openWindow = window.open("", "title",  'left=0,top=0,toolbar=0,scrollbars=0,status=0');
    openWindow.document.write(divShowingCertificate.innerHTML);
    openWindow.document.close();
    openWindow.focus();
    openWindow.print();
    openWindow.close();
})

toggleDetail.addEventListener("click", function(e) {
    if(courseDetail.style.display == "none"){
        courseDetail.style.display = "block";
        toggleDetail.innerHTML = "Hide Description";
    }
    else {
        courseDetail.style.display = "none";
        toggleDetail.innerHTML = "Course Description";
    }
})

toggleFeedback.addEventListener("click", function(e) {
    if(hiddenFeedback.style.display == "none"){
        hiddenFeedback.style.display = "block";
        hiddenAnnouncement.style.display = "none";
        toggleDetail.style.display = "none";
        toggleCertificate.style.display = "none";
        toggleFeedback.innerHTML = "Announcement";
    }
    else {
        hiddenFeedback.style.display = "none";
        hiddenAnnouncement.style.display = "block";
        toggleDetail.style.display = "block";
        toggleCertificate.style.display = "block";
        toggleFeedback.innerHTML = "Feedback";
    }
})

toggleCertificate.addEventListener("click", function(e) {
    if(hiddenCertificate.style.display == "none"){
        hiddenCertificate.style.display = "block";
        hiddenAnnouncement.style.display = "none";
        toggleDetail.style.display = "none";
        toggleFeedback.style.display = "none";
        toggleCertificate.innerHTML = "Announcement";
    }
    else {
        hiddenCertificate.style.display = "none";
        hiddenAnnouncement.style.display = "block";
        toggleDetail.style.display = "block";
        toggleFeedback.style.display = "block";
        toggleCertificate.innerHTML = "Certificate";
    }
})

toggleStudentList.addEventListener("click", function(e) {
    if(hiddenStudentList.style.display == "none"){
        hiddenStudentList.style.display = "block";
        hiddenAnnouncement.style.display = "none";
        toggleDetail.style.display = "none";
        toggleUpdateSection.style.display = "none";
        toggleStudentList.innerHTML = "Announcement";
    }
    else {
        hiddenStudentList.style.display = "none";
        hiddenAnnouncement.style.display = "block";
        toggleDetail.style.display = "block";
        toggleUpdateSection.style.display = "block";
        toggleStudentList.innerHTML = "Student List";
    }
})

toggleUpdateSection.addEventListener("click", function(e) {
    if(hiddenUpdateSection.style.display == "none"){
        hiddenUpdateSection.style.display = "block";
        hiddenAnnouncement.style.display = "none";
        toggleDetail.style.display = "none";
        toggleStudentList.style.display = "none";
        toggleUpdateSection.innerHTML = "Announcement";
    }
    else {
        hiddenUpdateSection.style.display = "none";
        hiddenAnnouncement.style.display = "block";
        toggleDetail.style.display = "block";
        toggleStudentList.style.display = "block";
        toggleUpdateSection.innerHTML = "Update Section";
    }
})

cancelAnnouncementButton.addEventListener("click", function(e) {
    Array.from(hiddenAttributeNewAnnouncement).forEach(function(f) {
        newAnnouncementForm.reset();
        f.style.display = "none";
    });
});

newAnnouncementInput.addEventListener("click", function(e) {
    Array.from(hiddenAttributeNewAnnouncement).forEach(function(f) {
        if (f.style.display === "none") {
            f.style.display = "block";
        } 
    });
});



if ( window.history.replaceState ) {
    window.history.replaceState( null, null, window.location.href );
}