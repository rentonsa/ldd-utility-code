<div class="col-md-5 hidden-sm hidden-xs sidebar">
    <div class="sidebar-nav">

        <ul class="list-group">
            <li class="list-group-item">
                <?php
                if(isset($searchbox_filters) && count($searchbox_filters) > 0)
                {
                    $filter_segments = explode("\"", urldecode($searchbox_filters[0]));
                    $case_segments = explode("|||", urldecode($filter_segments[1]));

                    echo " " . $case_segments[1] . " ";
                }
                else {
                    echo "All " . urldecode($searchbox_query) . " ";
                }
                ?>
                records
                <a class="pull-right map-view">Map view</a>
            </li>
            <li class="list-group-item">
                <div id="map">
                </div>
            </li>
        </ul>
    </div>
</div>