var names = [];
var emails = [];

function addSanta($name, $email, $list){
  var name = $name.value;
  var email = $email.value;

  names.push(name);
  emails.push(email);

  $name.value = "";
  $email.value = "";

  appendItem($list, name +' ('+ email +')')
}

function sendSantas(){
  var request = new XMLHttpRequest();
  request.open('POST', 'index.php', true);
  request.setRequestHeader('Content-Type', 'application/json; charset=UTF-8');
  request.send(JSON.stringify({names: names, emails: emails, send: "true"}));
}

function appendItem($list, str){
  var item = document.createElement("li");                 // Create a <li> node
  var textnode = document.createTextNode(str);         // Create a text node
  item.appendChild(textnode);
  $list.appendChild(item)
}

window.onload = function(){
  var $addForm = document.getElementById('add-form');
  var $sendForm = document.getElementById('send-form');

  var $addName = document.getElementById('add-name');
  var $addEmail = document.getElementById('add-email');

  var $santaList = document.getElementById('santa-list');

  $addName.focus();

  $addForm.addEventListener('submit', function(e){
    e.preventDefault();
    addSanta($addName, $addEmail, $santaList)
    e.target.querySelectorAll('input')[0].focus();
  });

  $sendForm.addEventListener('submit', function(e){
    e.preventDefault();
    sendSantas()
  });
}
