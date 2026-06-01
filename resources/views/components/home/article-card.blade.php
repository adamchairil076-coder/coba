<div class="col-sm-6 col-lg-4">

   <div class="blog-item" style="height: 100%;">

      {{-- Thumbnail --}}
      <div class="top" style="
         width: 100%;
         height: 250px;
         overflow: hidden;
         border-radius: 10px 10px 0 0;
      ">

         <a href="{{ route('blog.show', $slug) }}" style="
            display: block;
            width: 100%;
            height: 100%;
         ">

            <img 
               src="{{ asset('storage/'.$thumbnail) }}" 
               alt="Blog"
               style="
                  width: 100% !important;
                  height: 250px !important;
                  object-fit: cover !important;
                  object-position: center !important;
                  display: block !important;
                  border-radius: 10px 10px 0 0;
               "
            >

         </a>

      </div>

      {{-- Content --}}
      <div class="bottom">

         <ul>

            <li>
               <i class="icofont-calendar"></i>
               <span>{{ $date }}</span>
            </li>

            <li>
               <i class="icofont-user-alt-3"></i>
               <a href="{{ route('blog.author', $author) }}">
                  {{ $author }}
               </a>
            </li>

         </ul>

         <h3>
            <a href="{{ route('blog.show', $slug) }}">
               {{ $title }}
            </a>
         </h3>

         <a class="blog-btn" href="{{ route('blog.show', $slug) }}">
            Baca selengkapnya
         </a>

      </div>

   </div>

</div>