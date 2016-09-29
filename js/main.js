var names = [];
var emails = [];
var elems = {};
var errors = [];

function addSanta(){
  errors = [];
  while (elems.$addErrors.firstChild) {
    elems.$addErrors.removeChild(elems.$addErrors.firstChild);
  }

  var name = elems.$addName.value;
  var email = elems.$addEmail.value;

  names.push(name);
  emails.push(email);

  if(hasDuplicates(names)){
    errors.push('Name must be unique')
  }

  if(hasDuplicates(emails)){
    errors.push('Email must be unique')
  }

  if(errors.length > 0){
    names.pop()
    emails.pop()
    var p = appendItem(elems.$addErrors, "p", undefined)
    errors.forEach(function(error){ appendItem(p, "div", error)})
  }else {
    elems.$addName.value = "";
    elems.$addEmail.value = "";
    appendItem(elems.$santaList, "li", name +' ('+ email +')')
  }
}

function sendSantas(){
  errors = [];
  while (elems.$sendErrors.firstChild) {
    elems.$sendErrors.removeChild(elems.$sendErrors.firstChild);
  }

  var request = new XMLHttpRequest();

  request.onreadystatechange = function(){
    debugger;
    var DONE = 4; // readyState 4 means the request is done.
    var OK = 200; // status 200 is a successful return.
    if (request.readyState === DONE) {
      if (request.status === OK){
        console.log(request.responseText); // 'This is the returned text.'
      } else {
        console.log('Error: ' + request.status); // An error occurred during the request.
      }
    }
  };

  request.open('POST', 'index.php', true);
  request.setRequestHeader('Content-Type', 'application/json; charset=UTF-8');
  request.send(JSON.stringify({names: names, emails: emails, send: "true"}));
}



function appendItem($elem, element, str){
  var item = document.createElement(element);
  $elem.appendChild(item)

  if(!! str){
    var textnode = document.createTextNode(str);
    item.appendChild(textnode);
  }

  return item;
}

window.onload = function(){
  elems.$addForm = document.getElementById('add-form');
  elems.$sendForm = document.getElementById('send-form');

  elems.$addName = document.getElementById('add-name');
  elems.$addEmail = document.getElementById('add-email');

  elems.$addErrors = document.getElementById('add-errors');
  elems.$sendErrors = document.getElementById('send-errors');

  elems.$santaList = document.getElementById('santa-list');

  elems.$addName.focus();

  elems.$addForm.addEventListener('submit', function(e){
    e.preventDefault();
    addSanta()
    e.target.querySelectorAll('input')[0].focus();
  });

  elems.$sendForm.addEventListener('submit', function(e){
    e.preventDefault();
    sendSantas()
  });
}

function hasDuplicates(array) {
  var values = [];
  for (var i = 0; i < array.length; ++i) {
    var value = array[i];
    if (values.indexOf(value) !== -1) {
      return true;
    }
    values.push(value);
  }
  return false;
}
