document.getElementById('filters-btn').addEventListener('click', function() {
    var filterDiv = document.getElementById('filters');
    if (filterDiv.style.display === 'none' || filterDiv.style.display === '') {
        filterDiv.style.display = 'block';
    } else {
        filterDiv.style.display = 'none';
    }
});