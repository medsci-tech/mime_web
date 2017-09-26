<div class="questions_modal modal fade" id="questionsModal" tabindex="-1" role="dialog"
     aria-labelledby="successModal" style="overflow: scroll;">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h3 class="title text-center">答题</h3>
            <form id="questionForm">
                <ol class="questions">
                    @if($questions && $questions->count())
                        @foreach($questions as $question)
                            <li class="question_container">
                                {{--<span class="icon icon_success"></span>--}}
                                <h4 class="question">{{$question->question}}</h4>
                                <ol class="choices">
                                    @foreach(unserialize($question->option) as $key => $val)
                                        <li class="choice">
                                            <div class="radio">
                                                <label>
                                                    <input type="radio" name="q_{{$question->id}}" value="{{$key}}">
                                                    <span class="radio_img"></span>
                                                    {{$val}}
                                                </label>
                                            </div>
                                        </li>
                                    @endforeach
                                </ol>
                            </li>
                        @endforeach
                    @endif
                </ol>
            </form>
            <button type="button" class="btn btn-block btn_questions_modal_confirm">提交</button>
        </div>
    </div>
</div>
