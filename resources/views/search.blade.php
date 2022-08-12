<div>    
    <div class="row" style="margin-left: 3px;">
        <br>
        <form class="form-inline">
            <div class="form-group mb-2">
            <label for="exampleFormControlSelect1" style="margin-top: 27px;"><h6 style="font-family: sans-serif;font-size: 18px;font-weight: 700;">Search for</h6></label>
            </div>
            <div class="form-group mx-sm-3 mb-2">
                <div class="dropdown">
                    <button id="dLabel" class="dropdown-select" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Select
                        <span class="caret"></span>
                    </button>
                    <ul class="dropdown-menu" aria-labelledby="dLabel">
                        <li >Select</li>
                        <li data-value="OccID">OccID</li>
                        <li data-value="Member_Fistname">First Name</li>
                        <li data-value="Member_lastname" >Last Name</li>
                        <li  >Alphabetic</li>

                    </ul>
                </div>
            </div>
            <div class="form-group mx-sm-3 mb-2">
                <input type="text" id="searchkey" class="form-control" style="margin-top: 24px;" >
            </div>
            <div class="form-group mx-sm-3 mb-2">
                <button type="submit" style="margin-top: 24px;" class="btn btn-primary" id="search">Search</button>
            </div>
        </form>
    </div>
    <div class="rows mt-4" >
        {{-- <div class="center col-12">
            <p class="float-sm-right pcursor print-excel" style="" id="print">PRINT</p>
            <span class="float-sm-right pcursor" style="margin-left: 5px;margin-right: 5px;">*</span>
            <p class="float-sm-right print-excel"   id="excel" >EXCEL</p>
            <a href="" id="download-excel" class="download-excel" hidden ></a>
        </div> --}}
        <div id="printview">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th scope="col">OccID</th>
                        <th scope="col">First Name</th>
                        <th scope="col">Last Name</th>
                        <th scope="col">HCP</th>
                    </tr>
                </thead>
                <tbody id="result">
                </tbody>
            </table>
        </div>
    </div>

</div>