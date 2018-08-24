<div class="sidebar-title" style="padding:10px;">
    <div class="text-right">
        <button class="btn btn-xs btn-primary" type="button" data-toggle="modal", data-target="#rateModal_{{str_replace(' ','_', $operator['mobileOperator'])}}">
            <i class="fa fa-star"></i> Rate
        </button>
        <button class="btn btn-xs btn-success" type="button" data-toggle="modal", data-target="#reviewModal_{{str_replace(' ','_', $operator['mobileOperator'])}}">
            <i class="fa fa-edit"></i> Review
        </button>
        <div class="btn-group">
            <button data-toggle="dropdown" class="btn btn-xs btn-warning" type="button">
                <i class="fa fa-copy"></i> Compare
                <span class="caret"></span>
            </button>
            <ul class="dropdown-menu">
                <li><a href="#">Smart</a></li>
                <li><a href="#">Smart</a></li>
            </ul>
        </div>
    </div>
</div>