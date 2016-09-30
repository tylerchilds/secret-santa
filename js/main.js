var host, group;
var names = [];
var emails = [];
var elems = {};
var errors = [];

function createGroup(){
  errors = [];
  while ($('create-errors').firstChild) {
    $('create-errors').removeChild($('create-errors').firstChild);
  }

  host = $('create-host').value;
  group = $('create-group').value;

  $('add-name').focus();
  $('step-1').className += " prev";
  $('step-2').className += " next";
}

function addSanta(){
  errors = [];
  while ($('add-errors').firstChild) {
    $('add-errors').removeChild($('add-errors').firstChild);
  }

  while ($('send-errors').firstChild) {
    $('send-errors').removeChild($('send-errors').firstChild);
  }

  var name = $('add-name').value;
  var email = $('add-email').value;

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
    writeErrors($('add-errors'), errors)
  }else {
    $('add-name').value = "";
    $('add-email').value = "";
    $('group').innerHTML = group;
    appendItem($('santa-list'), "li", name +' ('+ email +')')
  }
}

function sendSantas(){
  errors = [];
  while ($('send-errors').firstChild) {
    $('send-errors').removeChild($('send-errors').firstChild);
  }

  var request = new XMLHttpRequest();

  request.onreadystatechange = function(){
    var DONE = 4; // readyState 4 means the request is done.
    var OK = 200; // status 200 is a successful return.
    if (request.readyState === DONE) {
      if (request.status === OK){
        $('step-2').className += " prev";
        $('step-3').className += " next";
      } else {
        writeErrors($('send-errors'), [JSON.parse(request.response).error])
      }
    }
  };

  request.open('POST', 'index.php', true);
  request.setRequestHeader('Content-Type', 'application/json; charset=UTF-8');
  request.send(JSON.stringify({
    names: names,
    emails: emails,
    host: host,
    group: group,
    send: "true"
  }));
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
  $('create-host').focus();

  $('create-form').addEventListener('submit', function(e){
    e.preventDefault();
    createGroup()
  });

  $('add-form').addEventListener('submit', function(e){
    e.preventDefault();
    addSanta()
    e.target.querySelectorAll('input')[0].focus();
  });

  $('send-form').addEventListener('submit', function(e){
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

function $(id){
  return document.getElementById(id)
}

function writeErrors(el, arr){
  var p = appendItem(el, "p", undefined)
  arr.forEach(function(e){ appendItem(p, "div", e)})
}
