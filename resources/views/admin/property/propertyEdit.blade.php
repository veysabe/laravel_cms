<div id="app">
    {!! $bar !!}
</div>

<script>
    let type_select = document.querySelectorAll('[name="sectionProperty[type]"]')[0];
    let matrix_field_set = document.querySelectorAll('.matrix')[0];
    if (matrix_field_set) {
        let parent_matrix = matrix_field_set.closest('fieldset');
        parent_matrix.classList.add('hidden');
        type_select.addEventListener('select', function (e) {
            console.log(e);
        })
    }
    // console.log(parent_matrix);
</script>

<style>
    .hidden {
        display: none;
    }
</style>


