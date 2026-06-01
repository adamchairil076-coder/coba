<div class="col-xl-3 col-lg-3 col-md-6 col-sm-12 mb-3">

    @isset($link)
        <a href="{{ $link }}" style="text-decoration: none; color: inherit;">
    @endisset

    <div class="info-box shadow-sm"
         style="
            min-height: 105px;
            border-radius: 14px;
            padding: 14px 16px;
            display: flex;
            align-items: center;
            transition: .3s;
            background: #ffffff;
            cursor: {{ isset($link) ? 'pointer' : 'default' }};
         "
         onmouseover="this.style.transform='translateY(-3px)'; this.style.boxShadow='0 8px 18px rgba(0,0,0,0.15)'"
         onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow=''">

        <span class="info-box-icon bg-{{ $color }} elevation-1"
              style="
                width: 65px;
                height: 65px;
                min-width: 65px;
                border-radius: 14px;
                font-size: 26px;
                display: flex;
                align-items: center;
                justify-content: center;
              ">

            <i class="fas fa-{{ $icon }}"></i>

        </span>

        <div class="info-box-content"
             style="
                padding-left: 14px;
                overflow: hidden;
             ">

            <span class="info-box-text"
                  style="
                    font-size: 14px;
                    font-weight: 600;
                    color: #222;
                    white-space: normal;
                    line-height: 1.3;
                  ">

                {{ $text }}

            </span>

            <span class="info-box-number"
                  style="
                    font-size: 22px;
                    margin-top: 6px;
                    font-weight: 700;
                    color: #111;
                    word-break: break-word;
                  ">

                {{ $value }}

            </span>

        </div>

    </div>

    @isset($link)
        </a>
    @endisset

</div>