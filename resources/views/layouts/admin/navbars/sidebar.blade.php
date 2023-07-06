<div class="sidebar">
    <div class="sidebar-wrapper">
        <div class="logo">
            <a href="#" class="simple-text logo-mini">{{ __('QD') }}</a>
            <a href="#" class="simple-text logo-normal">{{ __('Quiz Dashboard') }}</a>
        </div>
        <ul class="nav">
            <li @if ($pageSlug == 'dashboard') class="active " @endif>
                <a href="{{ route('dashboard') }}">
                    <i class="tim-icons icon-chart-pie-36"></i>
                    <p>{{ __('Dashboard') }}</p>
                </a>
            </li>
            <li>
                <a data-toggle="collapse" href="#category-section">
                    <i class="fab fa-laravel" ></i>
                    <span class="nav-link-text" >{{ __('Categories') }}</span>
                    <b class="caret mt-1"></b>
                </a>

                <div class="collapse {{ $pageSlug == 'category'?'show':''}}" id="category-section">
                    <ul class="nav pl-4">
                        <li @if ($pageSlug == 'category') class="active " @endif>
                            <a href="{{ route('category.index')  }}">
                                <i class="tim-icons icon-bullet-list-67"></i>
                                <p>{{ __('Category Management') }}</p>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
            <li>
                <a data-toggle="collapse" href="#question-section">
                    <i class="fab fa-laravel" ></i>
                    <span class="nav-link-text" >{{ __('Questions') }}</span>
                    <b class="caret mt-1"></b>
                </a>

                <div class="collapse {{ $pageSlug == 'question'?'show':''}}" id="question-section">
                    <ul class="nav pl-4">
                        <li @if ($pageSlug == 'question') class="active " @endif>
                            <a href="{{ route('question.index')  }}">
                                <i class="tim-icons icon-bullet-list-67"></i>
                                <p>{{ __('Questions Management') }}</p>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
            <li>
                <a data-toggle="collapse" href="#answer-section">
                    <i class="fab fa-laravel" ></i>
                    <span class="nav-link-text" >{{ __('Answer Options') }}</span>
                    <b class="caret mt-1"></b>
                </a>

                <div class="collapse {{ $pageSlug == 'answer'?'show':''}}" id="answer-section">
                    <ul class="nav pl-4">
                        <li @if ($pageSlug == 'answer') class="active " @endif>
                            <a href="{{ route('answer.index')  }}">
                                <i class="tim-icons icon-bullet-list-67"></i>
                                <p>{{ __('Answer Management') }}</p>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
            <li>
                <a data-toggle="collapse" href="#quiz-section">
                    <i class="fab fa-laravel" ></i>
                    <span class="nav-link-text" >{{ __('Quiz') }}</span>
                    <b class="caret mt-1"></b>
                </a>

                <div class="collapse {{ $pageSlug == 'quiz'?'show':''}}" id="quiz-section">
                    <ul class="nav pl-4">
                        <li @if ($pageSlug == 'quiz') class="active " @endif>
                            <a href="{{ route('quiz.index')  }}">
                                <i class="tim-icons icon-bullet-list-67"></i>
                                <p>{{ __('Quiz Management') }}</p>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
        </ul>
    </div>
</div>