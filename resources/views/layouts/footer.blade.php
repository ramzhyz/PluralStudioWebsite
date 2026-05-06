<footer style="
    border-top: 1px solid var(--light-border);
    padding: 3rem 2.5rem;
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 3rem;
    background: var(--warm-white);
">
    <div>
        <h4 style="font-size:0.6rem; font-weight:500; letter-spacing:0.2em; text-transform:uppercase; margin-bottom:0.9rem;">About Plural Studio</h4>
        <p style="font-size:0.68rem; line-height:1.85; color:var(--mid-gray); margin-bottom:1rem;">
            Plural Studio is a creative production space built for content creation, movement, and recovery.
            Designed as a set of distinct environments from natural-light studios to a performance-driven
            athletics space and private recovery, each area is intentional and ready to shoot.
        </p>
        <p style="font-size:0.68rem; line-height:1.85; color:var(--mid-gray);">
            It operates as a place to produce with clarity. No excess, no distractions, just well-designed
            spaces that support strong output across creative and physical work.
        </p>
    </div>

    <div style="display:flex; flex-direction:column; gap:2rem;">
        <div>
            <h4 style="font-size:0.6rem; font-weight:500; letter-spacing:0.2em; text-transform:uppercase; margin-bottom:0.75rem;">Location</h4>
            <p style="font-size:0.68rem; line-height:1.8; color:var(--mid-gray);">
                <strong style="color:var(--charcoal); font-weight:500;">Plural Studio</strong><br>
                Jl. Raya Padangtai, Sirauta, Tibubeneng, Kec. Kuta Utara,<br>
                Kabupaten Badung, Bali 80361
            </p>
        </div>

        <div>
            <h4 style="font-size:0.6rem; font-weight:500; letter-spacing:0.2em; text-transform:uppercase; margin-bottom:0.75rem;">Receive Updates</h4>
            <form style="display:flex; border:1px solid var(--light-border);" onsubmit="return false;">
                <input
                    type="email"
                    placeholder="Email Address"
                    style="
                        flex:1; padding:0.65rem 0.9rem;
                        font-size:0.65rem; border:none; outline:none;
                        background:transparent; font-family:'DM Sans',sans-serif;
                        color:var(--charcoal); letter-spacing:0.05em;
                    "
                >
                <button type="submit" style="
                    padding:0.65rem 1.1rem;
                    background:var(--charcoal); color:#fff;
                    font-size:0.6rem; letter-spacing:0.15em;
                    text-transform:uppercase; border:none; cursor:pointer;
                    font-family:'DM Sans',sans-serif; transition:background 0.2s;
                " onmouseover="this.style.background='#333'" onmouseout="this.style.background='var(--charcoal)'">
                    Submit
                </button>
            </form>
        </div>
    </div>
</footer>
