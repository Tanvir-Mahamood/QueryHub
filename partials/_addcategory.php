<!-- Modal -->
<div class="modal fade" id="addCategory" tabindex="-1" aria-labelledby="addCategoryLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="addCategoryLabel">Add a new category</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="/forum/partials/_handlecategory.php" method="POST">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="addCategoryName" class="form-label">Add Category Name</label>
                        <input type="text" class="form-control" id="addCategoryName" name="addCategoryName" aria-describedby="emailHelp">
                        <div id="emailHelp" class="form-text">Try to enter unique category name</div>
                    </div>
                    <div class="mb-3">
                        <label for="addCategoryDesc" class="form-label">Add Category Description</label>
                        <input type="text" class="form-control" id="addCategoryDesc" name="addCategoryDesc">
                        <!--<textarea class="form-control" id="addCategoryDesc" name="addCategoryDesc" rows="3"></textarea>-->
                    </div>
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>