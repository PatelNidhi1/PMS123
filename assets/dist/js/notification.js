notifi = document.querySelector(".notification");
rowCount = document.querySelector(".row_count");
new_count = document.querySelector(".new_count");

setInterval(() =>{
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "notification.php", true);
    xhr.onload = ()=>{
      if(xhr.readyState === XMLHttpRequest.DONE){
          if(xhr.status === 200){
            let data = xhr.response;                         
            notifi.innerHTML = data;                                                  
          }
      }
    }
    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhr.send("");
}, 500);


setInterval(() =>{
  let xhr = new XMLHttpRequest();
  xhr.open("POST", "notification_row.php", true);
  xhr.onload = ()=>{
    if(xhr.readyState === XMLHttpRequest.DONE){
        if(xhr.status === 200){
          let data = xhr.response;                         
            
          

          if(data > rowCount.value){
            alert_toast('You have new annoucement',"info");
            rowCount.value = data;
            var c = data - rowCount.value ; 
            new_count.innerHTML = c + 1;
          }
        }
    }
  }
  xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  xhr.send("");
}, 500);


function getCookie(name) {
  var value = "; " + document.cookie;
  var parts = value.split("; " + name + "=");
  if (parts.length == 2) return parts.pop().split(";").shift();
}



  