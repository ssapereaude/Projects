/* 
 * Name: Filip Melka & Temur Rustamov
 * Date: April 2024
 */

package components;

import java.awt.Color;
import javax.swing.ImageIcon;
import javax.swing.JLabel;
import javax.swing.JPanel;
import javax.swing.SwingConstants;
import utils.Colors;
import utils.Fonts;

public class ResultRecord extends JPanel {

    JLabel[] labels;

    public ResultRecord(String[] data, int[] offsets, int width, int height, Color color, boolean win) {

        this.setBackground(color);
        this.setLayout(null);

        labels = new JLabel[4];
        for (int i = 0; i < data.length; i++) {
            labels[i] = new JLabel(data[i]);
            labels[i].setBackground(color);
            labels[i].setForeground(Colors.TEXT);
            labels[i].setFont(Fonts.DEFAULT);
            labels[i].setVerticalAlignment(SwingConstants.CENTER);
            labels[i].setBounds(offsets[i + 1], 0, 170, height);
            this.add(labels[i]);
        }

        /* add image */
        labels[3] = new JLabel(new ImageIcon("images/games/mines_" + (win ? "win" : "loss") + ".png"));
        labels[3].setBackground(color);
        labels[3].setVerticalAlignment(SwingConstants.CENTER);
        labels[3].setBounds(offsets[0], 0, height, height);
        this.add(labels[3]);

    }

}
