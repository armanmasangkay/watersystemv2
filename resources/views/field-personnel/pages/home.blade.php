@extends('field-personnel.layout.main')

@section('title', 'Home')

@section('content')
<h4 class="text-center mt-5">WELCOME ! <span class="text-primary ms-1">{{ Auth::user()->name }}</span></h4>
<h2 class="text-center mt-3" id="date"></h2>
<h3 class="text-center" id="time"></h3>
{{-- <div class="clock">
    <div class="outer-clock-face">
        <div class="marking marking-one"></div>
        <div class="marking marking-two"></div>
        <div class="marking marking-three"></div>
        <div class="marking marking-four"></div>
        <div class="inner-clock-face">
        <div class="hand hour-hand"></div>
        <div class="hand min-hand"></div>
        <div class="hand second-hand"></div>
        </div>
    </div>
</div> --}}




<div class="row justify-content-center">
    <form class="col-10 row" id="filter_barangay" action="{{ route('admin.filter') }}" method="post">
        @csrf
        <div class="form-group mt-2 col-md-4">
            <input type="hidden" name="barangay" id="barangay">
            <select class="form-select" id="brgy-dropdown">

            </select>
        </div>
        <div class="form-group mt-2 col-md-4">
            <input type="hidden" name="purok" id="purok">
            <select class="form-select" id="purok-dropdown" >
            </select>
        </div>
        <div class="mt-2 col-md-4">
          <button class="btn btn-primary form-control" type="submit">Filter</button>
        </div>
      </form>
</div>

<!-- Button trigger modal -->

  <!-- Modal -->
  <div class="modal fade modal-fullscreen" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="modal_title">Modal title</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <table id="table_data" class=" table table-striped table-bordered table-hover table-responsive">
                <thead>
                    <tr>
                        <td>Client</td>
                        <td>Account No</td>
                        <td>Serial No</td>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>June Vic Cadayona</td>
                        <td>12345</td>
                        <td>xxxxx</td>
                    </tr>
                    <tr>
                        <td>June Vic Cadayona</td>
                        <td>12345</td>
                        <td>xxxxx</td>
                    </tr>
                </tbody>
            </table>
            {{-- He was surprised that his immense laziness was inspirational to others.
            Fluffy pink unicorns are a popular status symbol among macho men.
            I am my aunt's sister's daughter.
            He drank life before spitting it out.
            The white water rafting trip was suddenly halted by the unexpected brick wall.
            If you don't like toenails, you probably shouldn't look at your feet.
            Siri became confused when we reused to follow her directions.
            The light that burns twice as bright burns half as long.
            The sun had set and so had his dreams.
            The river stole the gods.
            You've been eyeing me all day and waiting for your move like a lion stalking a gazelle in a savannah.
            Tom got a small piece of pie.
            He poured rocks in the dungeon of his mind.
            The teenage boy was accused of breaking his arm simply to get out of the test.
            The efficiency with which he paired the socks in the drawer was quite admirable.
            He decided to fake his disappearance to avoid jail.
            He found his art never progressed when he literally used his sweat and tears.
            As he entered the church he could hear the soft voice of someone whispering into a cell phone.
            When I cook spaghetti, I like to boil it a few minutes past al dente so the noodles are super slippery.
            He wondered if it could be called a beach if there was no sand.
            That must be the tenth time I've been arrested for selling deep-fried cigars.
            A quiet house is nice until you are ordered to stay in it for months.
            Tomatoes make great weapons when water balloons aren’t available.
            The shark-infested South Pine channel was the only way in or out.
            She looked at the masterpiece hanging in the museum but all she could think is that her five-year-old could do better.
            The changing of down comforters to cotton bedspreads always meant the squirrels had returned.
            The stranger officiates the meal.
            Jeanne wished she has chosen the red button.
            It's never comforting to know that your fate depends on something as unpredictable as the popping of corn.
            There were three sphered rocks congregating in a cubed room.
            Plans for this weekend include turning wine into water.
            The memory we used to share is no longer coherent.
            He excelled at firing people nicely.
            The bees decided to have a mutiny against their queen.
            The irony of the situation wasn't lost on anyone in the room.
            He turned in the research paper on Friday; otherwise, he would have not passed the class.
            The door swung open to reveal pink giraffes and red elephants.
            There's no reason a hula hoop can't also be a circus ring.
            The sunblock was handed to the girl before practice, but the burned skin was proof she did not apply it.
            It was difficult for Mary to admit that most of her workout consisted of exercising poor judgment.
            Having no hair made him look even hairier.
            Two more days and all his problems would be solved.
            He's in a boy band which doesn't make much sense for a snake.
            The near-death experience brought new ideas to light.
            It's much more difficult to play tennis with a bowling ball than it is to bowl with a tennis ball.
            The crowd yells and screams for more memes.
            Kevin embraced his ability to be at the wrong place at the wrong time.
            Lucifer was surprised at the amount of life at Death Valley.
            No matter how beautiful the sunset, it saddened her knowing she was one day older.
            Rock music approaches at high velocity. --}}
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary">Understood</button>
        </div>
      </div>
    </div>
  </div>

{{-- <script>
    const secondHand = document.querySelector('.second-hand');
    const minsHand = document.querySelector('.min-hand');
    const hourHand = document.querySelector('.hour-hand');

    function setDate() {
        const now = new Date();

        const seconds = now.getSeconds();
        const secondsDegrees = ((seconds / 60) * 360) + 90;
        secondHand.style.transform = `rotate(${secondsDegrees}deg)`;

        const mins = now.getMinutes();
        const minsDegrees = ((mins / 60) * 360) + ((seconds/60)*6) + 90;
        minsHand.style.transform = `rotate(${minsDegrees}deg)`;

        const hour = now.getHours();
        const hourDegrees = ((hour / 12) * 360) + ((mins/60)*30) + 90;
        hourHand.style.transform = `rotate(${hourDegrees}deg)`;
    }

    setInterval(setDate, 1000);

    setDate();
</script> --}}
<script>
    filter_barangay.addEventListener('submit', (e)=>{
        e.preventDefault();
        modal_title.innerText = `${barangay.value} - ${purok.value}`;

        $('#staticBackdrop').modal("show");
    })
    startTime()
    function startTime() {
        const today = new Date();
        let h = today.getHours();
        let m = today.getMinutes();
        let s = today.getSeconds();
        m = checkTime(m);
        s = checkTime(s);
        document.getElementById('time').innerHTML =  h + ":" + m + ":" + s;
        setTimeout(startTime, 1000);
    }

    function checkTime(i) {
        if (i < 10) {i = "0" + i};  // add zero in front of numbers < 10
        return i;
    }

    var date =  new Date()
    var newDate = date.toDateString().split(' '),
        cleanDate = date.toLocaleString('default', { month: 'long' }) + ' ' + newDate[2] + ', ' + newDate[3]

    document.getElementById('date').innerHTML = cleanDate
</script>
@endsection

@section('custom-js')
<script src="{{ asset('assets/js/location.js') }}" defer></script>
<script src="{{ asset('assets/js/form-search-animation.js') }}" defer></script>
@endsection
