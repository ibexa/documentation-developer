# Pagination

This is a component directly linked to tables.

Every view has it's own offset spacing defined. You can set them up with [Bootstrap's spacing utilities](https://getbootstrap.com/docs/4.2/utilities/spacing/) according to the position of the table in the UI and if there is more content below the pagination component.

##<div class="mgt-3 header-line">Pagination</div>
<div class="ez-guidelines-pagination">
[[code_example {html}
<div class="row justify-content-center align-items-center mb-2 ez-pagination__spacing">
   <span class="ez-pagination__text">
       Viewing <strong>10</strong> out of <strong>11</strong> items
   </span>
</div>
<div class="row justify-content-center align-items-center ez-pagination__btn mb-5">
    <ul class="pagination ez-pagination">
        <li class="page-item prev disabled"><span class="page-link">Back</span></li>
        <li class="page-item active"><span class="page-link">1 <span class="sr-only">(current)</span></span></li>
        <li class="page-item"><a class="page-link" href="#">2</a></li>
        <li class="page-item next"><a class="page-link" href="#" rel="next">Next</a></li>
    </ul>
</div>
code_example]]
</div>

!!! note
    Code example's background has been colored to show Pagination's full features.