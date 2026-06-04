<style>
/* Minimal subset of the provided design for featured card */
.feat-wrap{display:grid;grid-template-columns:1fr 1fr;gap:20px;align-items:start}
.feat-card{background:var(--bookletto-cream);border-radius:18px;padding:20px;width:100%;box-shadow:0 24px 60px rgba(0,0,0,0.12)}
.feat-tag{display:inline-flex;align-items:center;gap:6px;background:var(--bookletto-gold-pale);color:var(--bookletto-gold);font-size:11px;font-weight:700;padding:6px 10px;border-radius:999px;margin-bottom:12px}
.feat-cover{width:100%;height:180px;border-radius:12px;background:linear-gradient(160deg,#001427,#003870);display:flex;align-items:center;justify-content:center;font-size:48px;margin-bottom:14px;position:relative;overflow:hidden}
.feat-cover::before{content:'';position:absolute;left:0;top:0;bottom:0;width:6px;background:linear-gradient(to bottom,var(--bookletto-gold-light),var(--bookletto-gold))}
.feat-genre{font-size:11px;font-weight:700;color:var(--bookletto-gold);margin-bottom:6px}
.feat-title{font-family:var(--font-display);font-size:18px;font-weight:700;color:var(--bookletto-navy);margin-bottom:6px}
.feat-author{font-size:12px;color:var(--bookletto-text-mid);margin-bottom:12px}
.feat-bot{display:flex;align-items:center;justify-content:space-between}
.feat-price{font-family:var(--font-display);font-size:20px;font-weight:900;color:var(--bookletto-navy)}
.btn-feat{background:var(--bookletto-navy);color:var(--bookletto-white);border:none;padding:10px 16px;border-radius:10px}
</style>

<div class="bookletto-shell">
    <div class="feat-wrap">
        @foreach($featuredBooks as $book)
            <div class="feat-card">
                <div class="feat-tag">Pilihan</div>
                <div class="feat-cover {{ $book->cover_gradient }}">
                    @if($book->cover_image)
                        <img src="{{ \Illuminate\Support\Facades\Storage::url($book->cover_image) }}" alt="{{ $book->title }}" class="absolute inset-0 h-full w-full object-cover">
                    @else
                        📖
                    @endif
                </div>
                <div class="feat-genre">{{ $book->category->name ?? 'Umum' }}</div>
                <div class="feat-title">{{ $book->title }}</div>
                <div class="feat-author">{{ $book->author }}</div>
                <div class="feat-bot">
                    <div><div class="feat-price">Rp {{ number_format($book->price,0,',','.') }}</div></div>
                    <a href="{{ route('books.show', $book) }}" class="btn-feat">Lihat Detail</a>
                </div>
            </div>
        @endforeach
    </div>
</div>
