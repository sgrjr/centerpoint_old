 <div class="search">
      <form method="POST" action="{{ url('/search') }}">
        {{ csrf_field() }}
        <div class="inner-form">
          <div class="input-field first-wrap">
            <input id="search" type="text" name="string" type="search" placeholder={{isset($search)? $search:"Search by title..."}} />
          </div>
          <div class="input-field second-wrap">

              <select data-trigger="" name="search_categories">
                <option placeholder="">TITLE</option>

                  @foreach($titleCategories AS $col)
                    @if(isset($searchCategory) && $col === $searchCategory)
                      <option value={{$col}} selected>{{$col}}</option>
                    @else
                      <option value={{$col}}>{{$col}}</option>
                    @endif
                  @endforeach
  
              </select>

          </div>
          <div class="input-field third-wrap">
            <button class="btn-search" type="submit"><i class="fas fa-search"></i></button>
          </div>
        </div>
      </form>
    </div>