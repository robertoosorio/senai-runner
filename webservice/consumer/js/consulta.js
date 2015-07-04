function findAll() {
    $.ajax({
        type: 'GET',
        url: rootURL,
        dataType: "json", // data type of response
        success: renderList
    });
}
 
function findByName(searchKey) {
    $.ajax({
        type: 'GET',
        url: rootURL + '/search/' + searchKey,
        dataType: "json",
        success: renderList
    });
}
 
function findById(id) {
    $.ajax({
        type: 'GET',
        url: rootURL + '/' + id,
        dataType: "json",
        success: function(data){
            $('#btnDelete').show();
            renderDetails(data);
        }
    });
}
 
function addWine() {
    console.log('addWine');
    $.ajax({
        type: 'POST',
        contentType: 'application/json',
        url: rootURL,
        dataType: "json",
        data: formToJSON(),
        success: function(data, textStatus, jqXHR){
            alert('Wine created successfully');
            $('#btnDelete').show();
            $('#wineId').val(data.id);
        },
        error: function(jqXHR, textStatus, errorThrown){
            alert('addWine error: ' + textStatus);
        }
    });
}
 
function updateWine() {
    $.ajax({
        type: 'PUT',
        contentType: 'application/json',
        url: rootURL + '/' + $('#wineId').val(),
        dataType: "json",
        data: formToJSON(),
        success: function(data, textStatus, jqXHR){
            alert('Wine updated successfully');
        },
        error: function(jqXHR, textStatus, errorThrown){
            alert('updateWine error: ' + textStatus);
        }
    });
}
 
function deleteWine() {
    console.log('deleteWine');
    $.ajax({
        type: 'DELETE',
        url: rootURL + '/' + $('#wineId').val(),
        success: function(data, textStatus, jqXHR){
            alert('Wine deleted successfully');
        },
        error: function(jqXHR, textStatus, errorThrown){
            alert('deleteWine error');
        }
    });
}
 
// Helper function to serialize all the form fields into a JSON string
function formToJSON() {
    return JSON.stringify({
        "id": $('#id').val(),
        "name": $('#name').val(),
        "grapes": $('#grapes').val(),
        "country": $('#country').val(),
        "region": $('#region').val(),
        "year": $('#year').val(),
        "description": $('#description').val()
        });
}